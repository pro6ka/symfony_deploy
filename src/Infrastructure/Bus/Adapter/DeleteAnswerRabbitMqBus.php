<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\DeleteAnswerBusInterface;
use App\Infrastructure\Bus\AmqpExchangeEnum;
use App\Infrastructure\Bus\RabbitMqBus;

readonly class DeleteAnswerRabbitMqBus implements DeleteAnswerBusInterface
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
    public function sendDeleteAnswerMessage(int $answerId): void
    {
        $this->rabbitMqBus->publishToExchange(
            AmqpExchangeEnum::DELETE_ANSWER,
            $answerId
        );
    }
}
