<?php

namespace App\Domain\Model;

use App\Domain\ValueObject\UserRoleEnum;

class CreateUserModel
{
    public function __construct(
        public readonly string $login,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly ?string $middleName = null,
        public readonly ?UserRoleEnum $userRole = null
    ) {
    }
}
