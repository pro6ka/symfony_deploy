<?php

namespace App\Controller\Web\Exercise\EditExercise\v1\Output;

use DateTime;

readonly class EditedExerciseDTO
{
    /**
     * @param int $id
     * @param string $title
     * @param string $content
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public DateTime $createdAt,
        public DateTime $updatedAt,
    ) {
    }
}
