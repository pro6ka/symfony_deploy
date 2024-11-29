<?php

namespace App\Controller\Web\Question\DeleteQuestion\v1;

use App\Domain\Entity\Question;
use App\Domain\Service\QuestionService;

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
     * @param Question $question
     *
     * @return void
     */
    public function deleteQuestion(Question $question): void
    {
        $this->questionService->deleteQuestion($question);
    }
}
