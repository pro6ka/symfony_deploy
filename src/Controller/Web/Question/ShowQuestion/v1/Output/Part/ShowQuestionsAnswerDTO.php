<?php

namespace App\Controller\Web\Question\ShowQuestion\v1\Output\Part;

readonly class ShowQuestionsAnswerDTO
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
