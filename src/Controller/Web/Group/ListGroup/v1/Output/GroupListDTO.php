<?php

namespace App\Controller\Web\Group\ListGroup\v1\Output;

use DateTime;

readonly class GroupListDTO
{
    /**
     * @param int $id
     * @param string $name
     * @param bool $isActive
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param int $participants
     */
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public int $participants = 0
    ) {
    }
}
