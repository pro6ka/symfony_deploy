<?php

namespace App\Controller\Amqp\DeleteExercise;

use App\Application\RabbitMQ\AbstractConsumer;
use App\Controller\Amqp\DeleteExercise\Input\Message;
use App\Domain\Exception\EntityHasFixationsException;
use App\Domain\Service\ExerciseService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class Consumer extends AbstractConsumer
{
    /**
     * @param ExerciseService $exerciseService
     */
    public function __construct(
        private readonly ExerciseService $exerciseService
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
        if (! $exercise = $this->exerciseService->findById($message->exerciseId)) {
            $this->reject(sprintf('Exercise ID %d was not found', $message->exerciseId));
        }

        $this->exerciseService->deleteRevisionable($exercise);

        return self::MSG_ACK;
    }
}
