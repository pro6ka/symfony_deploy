<?php

namespace App\Domain\Model\Exercise;

use App\Domain\Entity\WorkShop;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateExerciseModel
{
    /**
     * @param string $title
     * @param string $content
     * @param WorkShop $workshop
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
        public WorkShop $workshop
    ) {
    }
}