<?php

namespace App\Controller\Web\User\CreateUser\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Domain\ValueObject\UserRoleEnum;
use DateTime;

readonly class CreatedUserDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $login
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param DateTime $createdAt
     * @param null|string $middleName
     * @param null|UserRoleEnum $userRole
     * @param array $appRoles
     */
    public function __construct(
        public int $id,
        public string $login,
        public string $firstName,
        public string $lastName,
        public string $email,
        public DateTime $createdAt,
        public ?string $middleName = null,
        public ?UserRoleEnum $userRole = null,
        /** @var string[] $appRoles */
        public array $appRoles = []
    ) {
    }
}
