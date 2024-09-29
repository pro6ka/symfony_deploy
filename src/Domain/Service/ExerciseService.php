<?php

namespace App\Domain\Service;

use App\Domain\Entity\Exercise;
use App\Domain\Entity\Fixation;
use App\Domain\Entity\Group;
use App\Domain\Entity\Revision;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Infrastructure\Repository\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class ExerciseService
{
    /**
     * @param ExerciseRepository $exerciseRepository
     */
    public function __construct(
        private FixationService $fixationService,
        private ExerciseRepository $exerciseRepository
    ) {
    }

    /**
     * @param string $title
     * @param string $content
     * @param WorkShop $workShop
     *
     * @return int
     */
    public function create(
        string $title,
        string $content,
        WorkShop $workShop
    ): int {
        $exercise = new Exercise();
        $exercise->setTitle($title);
        $exercise->setContent($content);
        $exercise->setWorkShop($workShop);

        return $this->exerciseRepository->create($exercise);
    }

    /**
     * @param int $exerciseId
     *
     * @return null|Exercise
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $exerciseId): ?Exercise
    {
        return $this->exerciseRepository->findById($exerciseId);
    }

    public function getByIdForUser(int $exerciseId, User $user, Group $group)
    {
        $exercise = $this->exerciseRepository->findById($exerciseId);
        $revisions = array_reduce(
            $this->fixationService->listForUserByEntity($exercise->getWorkShop()->getExercises(), $user, $group),
            function ($carry, Fixation $fixation) {
                /** @var Revision $revision */
                foreach ($fixation->getRevisions() as $revision) {
                    $carry[$revision->getEntityId()][$revision->getColumnName()] = $revision;
                }

                return $carry;
            }
        );

        /** @var Exercise $exercise */
        if (isset($revisions[$exercise->getId()]) && $revisions[$exercise->getId()]) {
            $revisionColumns = $revisions[$exercise->getId()];
            foreach ($exercise->revisionableFields() as $field) {
                /** @var Revision $revision */
                $revision = $revisionColumns[$field];
                if (isset($revisionColumns[$field])) {
                    $setter = 'set' . ucfirst($revision->getColumnName());
                    if (method_exists($exercise, $setter)) {
                        $exercise->$setter($revision->getContentAfter());
                    }
                }
            }
        }

        return $exercise;
    }
}
