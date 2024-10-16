<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\WorkShop;
use App\Domain\Model\Exercise\CreateExerciseModel;
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
     * @param CreateExerciseModel $createExerciseModel
     *
     * @return Exercise
     */
    public function create(CreateExerciseModel $createExerciseModel): Exercise
    {
        $exercise = new Exercise();
        $exercise->setTitle($createExerciseModel->title);
        $exercise->setContent($createExerciseModel->content);
        $exercise->setWorkShop($createExerciseModel->workshop);

        $this->exerciseRepository->create($exercise);

        return $exercise;
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
