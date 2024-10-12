<?php

namespace App\Domain\Model\Workshop;

use Symfony\Component\Validator\Constraints as Assert;

readonly class EditWorkshopModel
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
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
        public string $description
    ) {
    }
}
