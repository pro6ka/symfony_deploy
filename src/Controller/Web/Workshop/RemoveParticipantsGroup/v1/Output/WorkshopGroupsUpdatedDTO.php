<?php

namespace App\Controller\Web\Workshop\RemoveParticipantsGroup\v1\Output;

use App\Controller\Web\Group\AddParticipantGroup\v1\Output\Part\GroupParticipantDTO;
use DateTime;

readonly class WorkshopGroupsUpdatedDTO
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param array $groups
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        /** @var GroupParticipantDTO[] */
        public array $groups
    ) {
    }
}
