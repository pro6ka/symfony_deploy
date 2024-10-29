<?php

namespace App\Domain\Bus;

use App\Domain\DTO\StartWorkShopDTO;

interface StartWorkshopBusInterface
{
    /**
     * @param StartWorkShopDTO $startWorkShopDTO
     *
     * @return void
     */
    public function sendStartWorkShopMessage(StartWorkShopDTO $startWorkShopDTO): void;
}
