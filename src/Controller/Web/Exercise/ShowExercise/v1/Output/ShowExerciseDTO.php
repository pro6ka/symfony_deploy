<?php

namespace App\Controller\Web\Exercise\ShowExercise\v1\Output;

readonly class ShowExerciseDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $content
    ) {}
}

