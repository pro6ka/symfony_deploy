<?php

namespace App\Controller\Web\User\LeaveGroup\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserLeaveGroupDTO
{
    /**
     * @param int $userId
     * @param int $groupId
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $userId,
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $groupId
    ) {
    }
}
