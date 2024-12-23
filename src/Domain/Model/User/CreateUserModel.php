<?php

namespace App\Domain\Model\User;

use App\Domain\ValueObject\UserRoleEnum;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserModel
{
    /**
     * @param string $login
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param null|string $middleName
     * @param null|UserRoleEnum $userRole
     * @param array $appRoles
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 32)]
        public string $login,
        #[Assert\NotBlank]
        public string $password,
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 32)]
        public string $firstName,
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 32)]
        public string $lastName,
        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        #[Assert\Email(message: 'The email {{ value }} is not valid email')]
        public string $email,
        #[Assert\Length(min: 1, max: 32)]
        public ?string $middleName = null,
        #[Assert\Choice(callback: [UserRoleEnum::class, 'cases'])]
        public ?UserRoleEnum $userRole = null,
        public array $appRoles = []
    ) {
    }
}
