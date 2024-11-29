<?php

namespace App\Controller\Web\Answer\DeleteAnswer\v1;

use App\Domain\Entity\Answer;
use App\Domain\Service\AnswerService;

readonly class Manager
{
    /**
     * @param AnswerService $answerService
     */
    public function __construct(
        private AnswerService $answerService
    ) {
    }

    /**
     * @param Answer $answer
     *
     * @return void
     */
    public function deleteAnswer(Answer $answer): void
    {
        $this->answerService->deleteAsync($answer);
    }
}
