<?php

namespace App\Domain\Model;

use App\Domain\ValueObject\UserRoleEnum;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserModel
{
    /**
     * @param string $login
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param null|string $middleName
     * @param null|UserRoleEnum $userRole
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 32)]
        public string $login,
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 32)]
        public string $firstName,
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 32)]
        public string $lastName,
        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        #[Assert\Email]
        public string $email,
        #[Assert\Length(min: 1, max: 32)]
        public ?string $middleName = null,
        #[Assert\Choice(callback: [UserRoleEnum::class, 'cases'])]
        public ?UserRoleEnum $userRole = null
    ) {
    }
}
