<?php

namespace App\Controller\Web\Exercise\CreateExercise\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateExerciseDTO
{
    /**
     * @param string $title
     * @param string $content
     * @param int $workshopId
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, max: 100)]
        public string $title,
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, max: 255)]
        public string $content,
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $workshopId
    ) {
    }
}
