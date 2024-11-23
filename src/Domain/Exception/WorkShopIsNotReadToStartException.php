<?php

namespace App\Domain\Exception;

use Exception;
use PHPUnit\Event\Code\Throwable;

class WorkShopIsNotReadToStartException extends Exception
{
    public function __construct(
        private readonly int $workShopId,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            sprintf('WorkShop [%d] is not ready to start', $this->workShopId),
            $code,
            $previous
        );
    }
}
