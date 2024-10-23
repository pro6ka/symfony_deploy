<?php

namespace App\Controller\Web\Question\ListQuestion\v1;

use App\Domain\Service\QuestionService;

readonly class Manager
{
    public function __construct(
        private QuestionService $questionService
    ) {
    }

    public function listQuestions(int $page)
    {

    }
}
