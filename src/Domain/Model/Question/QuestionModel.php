<?php

namespace App\Domain\Model\Question;

use App\Domain\Contract\FixableModelInterface;
use App\Domain\Entity\Exercise;
use App\Domain\Model\Answer\AnswerModel;

readonly class QuestionModel implements FixableModelInterface
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param array|AnswerModel[] $answers
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public array $answers
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
