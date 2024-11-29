<?php

namespace App\Controller\Web\Exercise\EditExercise\v1;

use App\Controller\Web\Exercise\EditExercise\v1\Input\EditExerciseDTO;
use App\Controller\Web\Exercise\EditExercise\v1\Output\EditedExerciseDTO;
use App\Domain\Model\Exercise\EditExerciseModel;
use App\Domain\Service\ExerciseService;
use App\Domain\Service\ModelFactory;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param ModelFactory $modelFactory
     * @param ExerciseService $exerciseService
     */
    public function __construct(
        private ModelFactory $modelFactory,
        private ExerciseService $exerciseService
    ) {
    }

    /**
     * @param EditExerciseDTO $editExerciseDTO
     *
     * @return EditedExerciseDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function editExercise(EditExerciseDTO $editExerciseDTO): EditedExerciseDTO
    {
        $exercise = $this->exerciseService->editExercise($this->modelFactory->makeModel(
            EditExerciseModel::class,
            $editExerciseDTO->id,
            $editExerciseDTO->title,
            $editExerciseDTO->content
        ));

        if ($exercise) {
            return new EditedExerciseDTO(
                id: $exercise->getId(),
                title: $exercise->getTitle(),
                content: $exercise->getContent(),
                createdAt: $exercise->getCreatedAt(),
                updatedAt: $exercise->getUpdatedAt()
            );
        }

        throw new NotFoundHttpException(sprintf('Exercise id: %d not found', $editExerciseDTO->id));
    }
}
