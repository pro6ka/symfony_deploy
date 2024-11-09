<?php

namespace App\Domain\Model\Exercise;

use App\Domain\Model\Workshop\WorkShopModel;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateExerciseModel
{
    /**
     * @param string $title
     * @param string $content
     * @param WorkShopModel $workshop
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
        public WorkShopModel $workshop
    ) {
    }
}
