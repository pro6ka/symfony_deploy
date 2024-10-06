<?php

namespace App\Controller\Web\Group\ShowGroup\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

readonly class ShowGroupParticipantDTO implements OutputDTOInterface
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
