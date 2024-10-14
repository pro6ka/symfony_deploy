<?php

namespace App\Controller\Web\Group\AddParticipantGroup\v1\Output\Part;

readonly class GroupParticipantDTO
{
    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $middleName
     */
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public string $middleName = '',
    ) {
    }
}
