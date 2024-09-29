<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\WorkShop;
use App\Infrastructure\Repository\ExerciseRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class ExerciseService extends AbstractFixableService
{
    /**
     * @param FixationService $fixationService
     * @param RevisionService $revisionService
     * @param ExerciseRepository $exerciseRepository
     */
    public function __construct(
        private FixationService $fixationService,
        private RevisionService $revisionService,
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

    /**
     * @param int $exerciseId
     * @param int $userId
     * @param int $groupId
     *
     * @return null|Exercise|RevisionableInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getByIdForUser(int $exerciseId, int $userId, int $groupId): Exercise|RevisionableInterface|null
    {
        $exercise = $this->exerciseRepository->findById($exerciseId);
        $revisions = $this->findRevisionsByFixable(
            entity: $exercise,
            userId: $userId,
            groupId: $groupId
        );

        return $this->revisionService->applyToEntity($exercise, $revisions);
    }

    /**
     * @return FixationService
     */
    protected function getFixationService(): FixationService
    {
        return $this->fixationService;
    }
}
