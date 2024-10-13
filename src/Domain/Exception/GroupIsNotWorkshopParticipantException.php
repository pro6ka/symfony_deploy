<?php

namespace App\Domain\Exception;

use Exception;
use Throwable;

class GroupIsNotWorkshopParticipantException extends Exception implements WorkshopAccessExceptionInterface
{
    /**
     * @param int $groupId
     * @param int $workshopId
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        private readonly int $groupId,
        private readonly int $workshopId,
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getHttpResponseBody(): string
    {
        return sprintf('Group [%d] have not access to the workshop [%d]', $this->groupId, $this->workshopId);
    }
}
