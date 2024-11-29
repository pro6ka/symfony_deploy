<?php

namespace App\Domain\Model\Exercise;

use App\Domain\Contract\FixableModelInterface;
use App\Domain\Model\Question\QuestionModel;

readonly class ExerciseModel implements FixableModelInterface
{
    /**
     * @param int $id
     * @param string $title
     * @param string $content
     * @param array|QuestionModel[] $questions
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public array $questions = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->id;
    }
}
