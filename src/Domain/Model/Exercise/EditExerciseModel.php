<?php

namespace App\Domain\Model\Exercise;

use Symfony\Component\Validator\Constraints as Assert;

readonly class EditExerciseModel
{
    /**
     * @param int $id
     * @param string $title
     * @param string $content
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $id,
        #[Assert\NotBlank(allowNull: true, normalizer: 'trim')]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, max: 100)]
        public string $title,
        #[Assert\NotBlank(allowNull: true, normalizer: 'trim')]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, max: 255)]
        public string $content
    ) {
    }
}
