<?php

namespace App\Domain\Exception;

use Exception;
use Throwable;

class GroupIsNotWorkshopParticipantException extends Exception
{
    /**
     * @param int $groupId
     * @param int $workshopId
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        private readonly int $groupId,
        private readonly int $workshopId,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            sprintf('Group [%d] have not access to the workshop [%d]', $this->groupId, $this->workshopId),
            $code,
            $previous
        );
    }
}
