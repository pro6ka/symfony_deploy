<?php

namespace App\Controller\Web\Question\ListQuestion\v1\Output\Part;

readonly class ListQuestionsAnswerItemDTO
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
