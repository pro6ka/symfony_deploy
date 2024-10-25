<?php

namespace App\Domain\Bus;

use App\Domain\DTO\StartWorkShopDTO;

interface StartWorkshopBusInterface
{
    /**
     * @param StartWorkShopDTO $startWorkShopDTO
     *
     * @return mixed
     */
    public function sendStartWorkShopMessage(StartWorkShopDTO $startWorkShopDTO);
}
