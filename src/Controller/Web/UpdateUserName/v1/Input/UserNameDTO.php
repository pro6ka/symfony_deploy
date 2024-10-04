<?php

namespace App\Controller\Web\UpdateUserName\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserNameDTO
{
    /**
     * @param int $id
     * @param null|string $firstName
     * @param null|string $lastName
     * @param null|string $middleName
     */
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
        public ?string $middleName = null
    ) {
    }
}
