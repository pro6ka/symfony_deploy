<?php

namespace App\Controller\Web\Workshop\RemoveParticipantsGroup\v1\Output;

readonly class GroupParticipantsDTO
{
    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @param int $participants
     */
    public function __construct(
        public int $id,
        public string $name,
        public int $participants
    ) {
    }
}