<?php

namespace App\Domain\Model\Group;

use App\Domain\Model\User\UserModel;
use DateTime;

readonly class GroupModel
{
    /**
     * @param int $id
     * @param string $name
     * @param bool $isActive
     * @param DateTime $workingFrom
     * @param DateTime|null $workingTo
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param array|UserModel[] $participants
     */
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public DateTime $workingFrom,
        public ?DateTime $workingTo,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public array $participants = [],
    ) {
    }
}
