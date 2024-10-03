<?php

namespace App\Controller\Web\ListUser\v1\Output;

use App\Domain\ValueObject\UserRoleEnum;
use DateTime;

readonly class ListUserItemDTO
{
    /**
     * @param int $id
     * @param string $login
     * @param string $firstName
     * @param string $lastName
     * @param string $middleName
     * @param string $email
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param null|UserRoleEnum $userRole
     */
    public function __construct(
        public int $id,
        public string $login,
        public string $firstName,
        public string $lastName,
        public string $middleName,
        public string $email,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?UserRoleEnum $userRole = null
    ) {
    }
}
