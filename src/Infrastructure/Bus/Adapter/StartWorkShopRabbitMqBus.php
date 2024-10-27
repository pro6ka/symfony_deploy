<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\StartWorkshopBusInterface;
use App\Domain\DTO\StartWorkShopDTO;
use App\Infrastructure\Bus\AmqpExchangeEnum;
use App\Infrastructure\Bus\RabbitMqBus;

readonly class StartWorkShopRabbitMqBus implements StartWorkshopBusInterface
{
    /**
     * @param RabbitMqBus $rabbitMqBus
     */
    public function __construct(
        private RabbitMqBus $rabbitMqBus
    ) {
    }

    /**
     * @inheritDoc
     */
    public function sendStartWorkShopMessage(StartWorkShopDTO $startWorkShopDTO): void
    {
        $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::START_WORKSHOP, $startWorkShopDTO);
    }
}
