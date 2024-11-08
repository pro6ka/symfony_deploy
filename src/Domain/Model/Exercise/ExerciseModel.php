<?php

namespace App\Domain\Model\Exercise;

readonly class ExerciseModel
{
    /**
     * @param int $id
     * @param string $title
     * @param string $content
     * @param int $questions
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public int $questions = 0
    ) {
    }
}
