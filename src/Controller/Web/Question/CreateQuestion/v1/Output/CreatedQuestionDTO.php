<?php

namespace App\Controller\Web\Question\CreateQuestion\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

readonly class CreatedQuestionDTO implements OutputDTOInterface
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public QuestionsExerciseDTO $exercise,
        /** @var QuestionsAnswerDTO[] $answers */
        public array $answers
    ) {
    }
}
