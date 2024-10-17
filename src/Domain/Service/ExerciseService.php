<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Exercise;
use App\Domain\Model\Exercise\CreateExerciseModel;
use App\Domain\Model\Exercise\EditExerciseModel;
use App\Domain\Model\Exercise\ListExerciseModel;
use App\Domain\Trait\PaginationTrait;
use App\Infrastructure\Repository\ExerciseRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ExerciseService extends AbstractFixableService
{
    use PaginationTrait;

    /**
     * @param ValidatorInterface $validator
     * @param FixationService $fixationService
     * @param RevisionService $revisionService
     * @param ExerciseRepository $exerciseRepository
     */
    public function __construct(
        private ValidatorInterface $validator,
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

    /**
     * @param int $page
     *
     * @return Paginator
     */
    public function getList(int $page = 1): Paginator
    {
        return $this->exerciseRepository->getList(
            pageSize: ListExerciseModel::PAGE_SIZE,
            firstResult: $this->countOffset(page: $page, pageSize: ListExerciseModel::PAGE_SIZE)
        );
    }

    /**
     * @param EditExerciseModel $editExerciseModel
     *
     * @return null|Exercise
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function editExercise(EditExerciseModel $editExerciseModel): ?Exercise
    {
        $exercise = $this->exerciseRepository->findById($editExerciseModel->id);

        if (! $exercise) {
            return null;
        }

        $exercise->setTitle($editExerciseModel->title === null ? $exercise->getTitle() : $editExerciseModel->title);
        $exercise->setContent(
            $editExerciseModel->content === null
                ? $exercise->getContent()
                : $editExerciseModel->content
        );

        $violations = $this->validator->validate($exercise);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($exercise, $violations);
        }

        $this->exerciseRepository->update();

        return $exercise;
    }

    /**
     * @param Exercise $exercise
     *
     * @return void
     */
    public function deleteExercise(Exercise $exercise): void
    {
        $this->exerciseRepository->removeExercise($exercise);
    }
}
