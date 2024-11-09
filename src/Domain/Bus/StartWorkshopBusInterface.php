<?php

namespace App\Domain\Bus;

use App\Domain\DTO\WorkShop\FlushWorkShopCacheDTO;
use App\Domain\DTO\WorkShop\StartWorkShopDTO;

interface StartWorkshopBusInterface
{
    /**
     * @param StartWorkShopDTO $startWorkShopDTO
     *
     * @return void
     */
    public function sendStartWorkShopMessage(StartWorkShopDTO $startWorkShopDTO): void;

    /**
     * @param FlushWorkShopCacheDTO $flushWorkShopCacheDTO
     *
     * @return void
     */
    public function sendFlushWorkShopCacheMessage(FlushWorkShopCacheDTO $flushWorkShopCacheDTO): void;
}
