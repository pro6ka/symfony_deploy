<?php

namespace App\Controller\Web\Question\CreateQuestion\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Controller\Web\Question\CreateQuestion\v1\Output\Part\QuestionsAnswerDTO;
use App\Controller\Web\Question\CreateQuestion\v1\Output\Part\QuestionsExerciseDTO;
use DateTime;

readonly class CreatedQuestionDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param QuestionsExerciseDTO $exercise
     * @param array $answers
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public QuestionsExerciseDTO $exercise,
        /** @var QuestionsAnswerDTO[] $answers */
        public array $answers
    ) {
    }
}
