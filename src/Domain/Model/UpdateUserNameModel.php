<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserNameModel
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $id,
        #[Assert\NotBlank(allowNull: true, normalizer: 'trim')]
        public ?string $firstName = null,
        #[Assert\NotBlank(allowNull: true, normalizer: 'trim')]
        public ?string $lastName = null,
        #[Assert\NotBlank(allowNull: true, normalizer: 'trim')]
        public ?string $middleName = null,
    ) {
    }
}
