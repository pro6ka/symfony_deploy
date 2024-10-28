<?php

namespace App\Controller\Web\Answer\DeleteAnswer\v1;

use App\Domain\Entity\Answer;
use App\Domain\Service\AnswerService;

readonly class Manager
{
    public function __construct(
        private AnswerService $answerService
    ) {
    }

    public function deleteAnswer(Answer $answer)
    {
        return $this->answerService->deleteAnswer($answer);
    }
}
