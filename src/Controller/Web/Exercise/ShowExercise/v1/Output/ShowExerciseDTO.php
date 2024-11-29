<?php

namespace App\Controller\Web\Exercise\ShowExercise\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Controller\Web\Exercise\ShowExercise\v1\Output\Part\ShowExerciseQuestionDTO;

readonly class ShowExerciseDTO implements OutputDTOInterface
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
        /** @var ShowExerciseQuestionDTO[] */
        public array $questions = [],
    ) {
    }
}
