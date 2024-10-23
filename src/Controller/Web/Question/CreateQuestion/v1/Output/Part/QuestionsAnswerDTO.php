<?php

namespace App\Controller\Web\Question\CreateQuestion\v1\Output;

readonly class QuestionsAnswerDTO
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description
    ) {
    }
}
