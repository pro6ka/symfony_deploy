<?php

namespace App\Controller\Web\Exercise\ShowExercise\v1;

use App\Domain\Service\ExerciseService;
use App\Controller\Web\Exercise\ShowExercise\v1\Output\ShowExerciseDTO;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Doctrine\ORM\Exception\ORMException;
use \Doctrine\ORM\OptimisticLockException;

readonly class Manager
{
    public function __construct(
        private ExerciseService $exerciseService
    ) {
    }

    /**
     * @param int $exerciseId
     *
     * @return ShowExerciseDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function showExercise(int $exerciseId): ShowExerciseDTO
    {
        if ($exercise = $this->exerciseService->findById($exerciseId)) {
            return new ShowExerciseDTO(
                id: $exercise->getId(),
                title: $exercise->getTitle(),
                content: $exercise->getContent(),
            );
        }

        throw new NotFoundHttpException(sprintf('Exercise id: %d not found', $exerciseId));
    }
}

