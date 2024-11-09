<?php

namespace App\Controller\Web\Workshop\AddParticipantsGroup\v1\Output\Part;

readonly class GroupParticipantsDTO
{
    /**
     * @param int $id
     * @param string $name
     * @param int $participants
     */
    public function __construct(
        public int $id,
        public string $name,
        public int $participants
    ) {
    }
}
