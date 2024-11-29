<?php

namespace App\Controller\Web\Question\CreateQuestion\v1\Output\Part;

readonly class QuestionsExerciseDTO
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
