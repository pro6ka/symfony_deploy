<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\DeleteRevisionableBusInterface;
use App\Domain\DTO\DeleteRevisionableDTO;
use App\Infrastructure\Bus\AmqpExchangeEnum;
use App\Infrastructure\Bus\RabbitMqBus;

readonly class DeleteRevisionableRabbitMqBus implements DeleteRevisionableBusInterface
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
    public function sendDeleteRevisionableMessage(DeleteRevisionableDTO $deleteRevisionableDTO): void
    {
        $this->rabbitMqBus->publishToExchange(
            exchange: AmqpExchangeEnum::DELETE_REVISIONABLE,
            message: $deleteRevisionableDTO,
            routingKey: strtolower(
                preg_replace(
                    '~(.*)\\\([^\\\]+)$~',
                    '$2',
                    $deleteRevisionableDTO->routingKey
                )
            )
        );
    }
}
