<?php

namespace App\Controller\Amqp\DeleteAnswer;

use App\Application\RabbitMQ\AbstractConsumer;
use App\Controller\Amqp\DeleteAnswer\Input\Message;
use App\Domain\Exception\EntityHasFixationsException;
use App\Domain\Service\AnswerService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class Consumer extends AbstractConsumer
{
    /**
     * @param AnswerService $answerService
     */
    public function __construct(
        private readonly AnswerService $answerService
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
        if (! $answer = $this->answerService->findById($message->entityId)) {
            return $this->reject(sprintf('Answer ID %d was not found', $message->entityId));
        }

        $this->answerService->deleteRevisionable($answer);

        return self::MSG_ACK;
    }
}
