<?php

namespace App\Controller\Web\CreateUser\v1\Input;

use App\Domain\ValueObject\UserRoleEnum;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserDTO
{
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
        public ?UserRoleEnum $userRole = null,
    ) {
    }
}