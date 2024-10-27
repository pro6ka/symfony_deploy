<?php

namespace App\Infrastructure\Bus;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class RabbitMqBus
{
    /** @var array<string, ProducerInterface> */
    private array $producers = [];

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    /**
     * @param AmqpExchangeEnum $exchange
     * @param ProducerInterface $producer
     *
     * @return void
     */
    public function registerProducer(AmqpExchangeEnum $exchange, ProducerInterface $producer): void
    {
        $this->producers[$exchange->value] = $producer;
    }

    /**
     * @param AmqpExchangeEnum $exchange
     * @param $message
     * @param null|string $routingKey
     * @param null|array $additionalProperties
     *
     * @return bool
     */
    public function publishToExchange(
        AmqpExchangeEnum $exchange,
        $message,
        ?string $routingKey = null,
        ?array $additionalProperties = null
    ): bool {
        if (isset($this->producers[$exchange->value])) {
            $serializedMessage = $this->serializer->serialize(
                $message,
                'json',
                [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]
            );
            $this->producers[$exchange->value]->publish(
                $serializedMessage,
                $routingKey ?? '',
                $additionalProperties ?? []
            );

            return true;
        }

        return false;
    }

    /**
     * @param AmqpExchangeEnum $exchange
     * @param array $messages
     * @param null|string $routingKey
     * @param null|array $additionalProperties
     *
     * @return bool
     */
    public function publishMultipleExchange(
        AmqpExchangeEnum $exchange,
        array $messages,
        ?string $routingKey = null,
        ?array $additionalProperties = null
    ): bool {
        $setCount = 0;

        foreach ($messages as $message) {
            if ($this->publishToExchange($exchange, $message, $routingKey, $additionalProperties)) {
                $setCount++;
            }
        }

        return $setCount > 0;
    }
}
