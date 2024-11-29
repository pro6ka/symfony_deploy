<?php

namespace App\Domain\Model\User;

use App\Domain\ValueObject\UserRoleEnum;

class ListUserItemModel
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
        public string $login,
        public string $firstName,
        public string $lastName,
        public string $email,
        public ?string $middleName = null,
        public ?UserRoleEnum $userRole = null
    ) {
    }
}
