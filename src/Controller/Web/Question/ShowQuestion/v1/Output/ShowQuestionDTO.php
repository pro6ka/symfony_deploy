<?php

namespace App\Controller\Web\Question\ShowQuestion\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Controller\Web\Question\ShowQuestion\v1\Output\Part\ShowQuestionExerciseDTO;
use App\Controller\Web\Question\ShowQuestion\v1\Output\Part\ShowQuestionsAnswerDTO;

readonly class ShowQuestionDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param ShowQuestionExerciseDTO $exercise
     * @param array $answers
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public ShowQuestionExerciseDTO $exercise,
        /** @var ShowQuestionsAnswerDTO[] $answers */
        public array $answers
    ) {
    }
}
