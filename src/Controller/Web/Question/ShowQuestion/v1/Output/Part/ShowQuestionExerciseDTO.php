<?php

namespace App\Controller\Web\Question\ShowQuestion\v1\Output\Part;

readonly class ShowQuestionExerciseDTO
{
    /**
     * @param int $id
     * @param string $title
     * @param string $content
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $content
    ) {
    }
}
