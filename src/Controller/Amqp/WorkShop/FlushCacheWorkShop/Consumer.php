<?php

namespace App\Controller\Amqp\WorkShop\FlushCacheWorkShop;

use App\Application\RabbitMQ\AbstractConsumer;
use App\Controller\Amqp\WorkShop\FlushCacheWorkShop\Input\Message;
use App\Domain\Repository\WorkShop\WorkShopRepositoryCacheInterface;

class Consumer extends AbstractConsumer
{
    /**
     * @param WorkShopRepositoryCacheInterface $workShopRepositoryCache
     */
    public function __construct(
        private readonly WorkShopRepositoryCacheInterface $workShopRepositoryCache
    ) {
    }

    /**
     * @inheritDoc
     */
    protected function getMessageClass(): string
    {
        return Message::class;
    }

    /**
     * @inheritDoc
     */
    protected function handle($message): int
    {
        $this->workShopRepositoryCache->flushForStartedCache($message->workShopId, $message->userId);

        return self::MSG_ACK;
    }
}
