<?php

namespace App\Domain\Model\Workshop;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateWorkshopModel
{
    /**
     * @param string $title
     * @param string $description
     * @param string $authorIdentifier
     */
    public function __construct(
        #[Assert\Length(min: 1, max: 100)]
        #[Assert\Type('string')]
        #[Assert\NotBlank]
        public string $title,
        #[Assert\Length(min: 1, max: 255)]
        #[Assert\Type('string')]
        #[Assert\NotBlank]
        public string $description,
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, max: 255)]
        public string $authorIdentifier
    ) {
    }
}
