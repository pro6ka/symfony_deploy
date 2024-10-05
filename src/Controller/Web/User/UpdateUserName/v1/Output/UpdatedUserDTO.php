<?php

namespace App\Controller\Web\User\UpdateUserName\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Domain\ValueObject\UserRoleEnum;
use DateTime;

readonly class UpdatedUserDTO implements OutputDTOInterface
{

    /**
     * @param int $id
     * @param string $login
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param null|string $middleName
     * @param null|UserRoleEnum $userRole
     */
    public function __construct(
        public int $id,
        public string $login,
        public string $firstName,
        public string $lastName,
        public string $email,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?string $middleName = null,
        public ?UserRoleEnum $userRole = null
    ) {
    }
}
