<?php

namespace App\Domain\Model\Group;

use DateTime;

readonly class ListGroupModel
{
    public const int PAGE_SIZE = 10;

    /**
     * @param int $id
     * @param string $name
     * @param bool $isActive
     * @param DateTime $workingFrom
     * @param DateTime|null $workingTo
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public DateTime $workingFrom,
        public ?DateTime $workingTo,
        public DateTime $createdAt,
        public DateTime $updatedAt,
    ) {
    }
}
