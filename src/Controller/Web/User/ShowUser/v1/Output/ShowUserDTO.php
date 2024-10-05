<?php

namespace App\Controller\Web\User\ShowUser\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Domain\ValueObject\UserRoleEnum;
use DateTime;

readonly class ShowUserDTO implements OutputDTOInterface
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
