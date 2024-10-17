<?php

namespace App\Controller\Web\Exercise\ShowExercise\v1\Output;

readonly class ShowExerciseQuestionDTO
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
