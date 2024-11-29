<?php

namespace App\Controller\Web\Exercise\ListExercise\v1\Output\Part;

use App\Controller\DTO\OutputDTOInterface;

readonly class ListExerciseQuestionDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $title
     */
    public function __construct(
        public int $id,
        public string $title
    ) {
    }
}
