<?php

namespace App\Controller\Web\Group\ListGroup\v1\Output\Part;

use DateTime;

class GroupListItemDTO
{
    /**
     * @param int $id
     * @param string $name
     * @param bool $isActive
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param int $participants
     * @param bool $isParticipant
     */
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public int $participants = 0,
        public bool $isParticipant = false
    ) {
    }
}
