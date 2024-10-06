<?php

namespace App\Controller\Web\Group\ShowGroup\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use DateTime;

readonly class ShowGroupDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $name
     * @param bool $isActive
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param array|ShowGroupParticipantDTO[] $participants
     */
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public array $participants = []
    ) {
    }
}