<?php

namespace App\Controller\Web\Exercise\ListExercise\v1\Output\Part;

readonly class ListExerciseItemDTO
{
    /**
     * @param int $id
     * @param string $title
     * @param string $content
     * @param array $questions
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        /** @var ListExerciseQuestionDTO[] */
        public array $questions
    ) {
    }
}
