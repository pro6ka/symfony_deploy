<?php

namespace App\Controller\Web\Question\ListQuestion\v1\Output\Part;

readonly class ListQuestionItemDTO
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param array $answers
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        /** @var ListQuestionsAnswerItemDTO[] */
        public array $answers
    ) {
    }
}
