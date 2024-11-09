<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\StartWorkshopBusInterface;
use App\Domain\DTO\WorkShop\FlushWorkShopCacheDTO;
use App\Domain\DTO\WorkShop\StartWorkShopDTO;
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
        $this->rabbitMqBus->publishToExchange(
            exchange: AmqpExchangeEnum::WORKSHOP,
            message: $startWorkShopDTO,
            routingKey: 'start'
        );
    }

    /**
     * @param FlushWorkShopCacheDTO $flushWorkShopCacheDTO
     *
     * @return void
     */
    public function sendFlushWorkShopCacheMessage(FlushWorkShopCacheDTO $flushWorkShopCacheDTO): void
    {
        $this->rabbitMqBus->publishToExchange(
            exchange: AmqpExchangeEnum::WORKSHOP,
            message: $flushWorkShopCacheDTO,
            routingKey: 'flush_cache'
        );
    }
}
