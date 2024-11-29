<?php

namespace App\Controller\Web\Question\ShowQuestion\v1;

use App\Controller\Web\Question\ShowQuestion\v1\Output\Part\ShowQuestionExerciseDTO;
use App\Controller\Web\Question\ShowQuestion\v1\Output\Part\ShowQuestionsAnswerDTO;
use App\Controller\Web\Question\ShowQuestion\v1\Output\ShowQuestionDTO;
use App\Domain\Entity\Answer;
use App\Domain\Service\QuestionService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param QuestionService $questionService
     */
    public function __construct(
        private QuestionService $questionService
    ) {
    }

    /**
     * @param int $questionId
     *
     * @return ShowQuestionDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function showQuestion(int $questionId): ShowQuestionDTO
    {
        if ($question = $this->questionService->findById($questionId)) {
            return new ShowQuestionDTO(
                id: $question->getId(),
                title: $question->getTitle(),
                description: $question->getDescription(),
                exercise: new ShowQuestionExerciseDTO(
                    id: $question->getExercise()->getId(),
                    title: $question->getExercise()->getTitle(),
                    content: $question->getExercise()->getContent(),
                ),
                answers: $question->getAnswers()->map(function (Answer $answer) {
                    return new ShowQuestionsAnswerDTO(
                        id: $answer->getId(),
                        title: $answer->getTitle(),
                        description: $answer->getDescription()
                    );
                })->toArray(),
            );
        }

        throw new NotFoundHttpException(sprintf('Question id: %d not found', $questionId));
    }
}
