<?php

namespace App\Controller\Web\Group\CreateGroup\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use DateTime;

readonly class CreatedGroupDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $name
     * @param bool $isActive
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param DateTime $workingFrom
     * @param null|DateTime $workingTo
     */
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public DateTime $workingFrom,
        public ?DateTime $workingTo,
    ) {
    }
}
