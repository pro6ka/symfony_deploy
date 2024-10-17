<?php

namespace App\Controller\Web\Exercise\ShowExercise\v1;

use App\Controller\Web\Exercise\ShowExercise\v1\Output\Part\ShowExerciseQuestionDTO;
use App\Controller\Web\Exercise\ShowExercise\v1\Output\ShowExerciseDTO;
use App\Domain\Entity\Question;
use App\Domain\Service\ExerciseService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
                questions: $exercise->getQuestions()->map(function (Question $question) {
                    return new ShowExerciseQuestionDTO(
                        id: $question->getId(),
                        title: $question->getTitle(),
                        description: $question->getDescription()
                    );
                })->toArray()
            );
        }

        throw new NotFoundHttpException(sprintf('Exercise id: %d not found', $exerciseId));
    }
}

