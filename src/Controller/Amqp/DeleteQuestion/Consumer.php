<?php

namespace App\Controller\Amqp\DeleteQuestion;

use App\Application\RabbitMQ\AbstractConsumer;
use App\Controller\Amqp\DeleteQuestion\Input\Message;
use App\Domain\Exception\EntityHasFixationsException;
use App\Domain\Service\QuestionService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class Consumer extends AbstractConsumer
{
    /**
     * @param QuestionService $questionService
     */
    public function __construct(
        private readonly QuestionService $questionService
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
     * @param $message
     *
     * @return int
     * @throws EntityHasFixationsException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function handle($message): int
    {
        if (! $question = $this->questionService->findById($message->questionId)) {
            $this->reject(sprintf('Question ID %d was not found', $message->questionId));
        }

        $this->questionService->deleteRevisionable($question);

        return self::MSG_ACK;
    }
}
