<?php

namespace App\Controller\Amqp\DeleteWorkShop;

use App\Application\RabbitMQ\AbstractConsumer;
use App\Controller\Amqp\DeleteWorkShop\Input\Message;
use App\Domain\Exception\EntityHasFixationsException;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class Consumer extends AbstractConsumer
{
    /**
     * @param WorkShopService $workShopService
     */
    public function __construct(
        private readonly WorkShopService $workShopService
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
     * @param Message $message
     *
     * @return int
     * @throws EntityHasFixationsException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function handle($message): int
    {
        if (! $question = $this->workShopService->findById($message->workShopId)) {
            $this->reject(sprintf('WorkShop ID %d was not found', $message->workShopId));
        }

        $this->workShopService->deleteRevisionable($question);

        return self::MSG_ACK;
    }
}
