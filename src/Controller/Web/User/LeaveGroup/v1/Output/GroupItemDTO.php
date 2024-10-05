<?php

namespace App\Controller\Web\User\LeaveGroup\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

readonly class GroupItemDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $name
     */
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
