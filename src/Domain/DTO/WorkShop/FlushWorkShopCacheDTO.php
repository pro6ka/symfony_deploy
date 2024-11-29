<?php

namespace App\Domain\DTO\WorkShop;

readonly class FlushWorkShopCacheDTO
{
    /**
     * @param int $userId
     * @param int $workShopId
     */
    public function __construct(
        public int $userId,
        public int $workShopId,
    ) {
    }
}
