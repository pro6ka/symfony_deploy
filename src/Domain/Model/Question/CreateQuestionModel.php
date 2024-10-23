<?php

namespace App\Domain\Model\Question;

use App\Domain\Entity\Exercise;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateQuestionModel
{
    /**
     * @param string $title
     * @param string $description
     * @param int $exerciseId
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, max: 100)]
        public string $title,
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, max: 100)]
        public string $description,
        #[Assert\NotBlank]
        public Exercise $exercise
    ) {
    }
}
