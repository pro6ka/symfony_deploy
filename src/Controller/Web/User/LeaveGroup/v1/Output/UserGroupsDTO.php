<?php

namespace App\Controller\Web\User\LeaveGroup\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

readonly class UserGroupsDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param array $groups
     */
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public string $email,
        public array $groups
    ) {
    }
}
