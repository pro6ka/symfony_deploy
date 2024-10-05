<?php

namespace App\Controller\Web\User\LeaveGroup\v1\Input;

readonly class UserLeaveGroupDTO
{
    /**
     * @param int $userId
     * @param int $groupId
     */
    public function __construct(
        public int $userId,
        public int $groupId
    ) {
    }
}
