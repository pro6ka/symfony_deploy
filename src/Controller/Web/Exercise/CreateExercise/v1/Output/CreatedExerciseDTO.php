<?php

namespace App\Controller\Web\Exercise\CreateExercise\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

readonly class CreatedExerciseDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $title
     * @param string $content
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
    ) {
    }
}
