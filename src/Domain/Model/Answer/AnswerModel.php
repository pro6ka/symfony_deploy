<?php

namespace App\Domain\Model\Answer;

use App\Domain\Contract\FixableModelInterface;

class AnswerModel implements FixableModelInterface
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description
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
