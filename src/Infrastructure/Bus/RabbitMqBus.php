<?php

namespace App\Infrastructure\Bus;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

readonly class RabbitMqBus
{
    /** @var array<string, ProducerInterface> */
    private array $producers;

    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    /**
     * @param AmqpQueueEnum $exchange
     * @param ProducerInterface $producer
     *
     * @return void
     */
    public function registerProducer(AmqpQueueEnum $exchange, ProducerInterface $producer): void
    {
        $this->producers[$exchange->value] = $producer;
    }

    /**
     * @param AmqpQueueEnum $exchange
     * @param $message
     * @param null|string $routingKey
     * @param null|array $additionalProperties
     *
     * @return bool
     */
    public function publishToExchange(
        AmqpQueueEnum $exchange,
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
     * @param AmqpQueueEnum $exchange
     * @param array $messages
     * @param null|string $routingKey
     * @param null|array $additionalProperties
     *
     * @return bool
     */
    public function publishMultipleExchange(
        AmqpQueueEnum $exchange,
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
