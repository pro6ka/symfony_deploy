<?php

namespace App\Controller\Web\Question\CreateQuestion\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateQuestionDTO
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
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $exerciseId
    ) {
    }
}
