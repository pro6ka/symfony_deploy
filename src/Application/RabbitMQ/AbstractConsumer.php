<?php

namespace App\Application\RabbitMQ;

use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Throwable;

abstract class AbstractConsumer implements ConsumerInterface
{
    private readonly EntityManagerInterface $entityManager;
    private readonly ValidatorInterface $validator;
    private readonly SerializerInterface $serializer;

    /**
     * @return string
     */
    abstract protected function getMessageClass(): string;

    /**
     * @param $message
     *
     * @return int
     */
    abstract protected function handle($message): int;

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return void
     */
    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ValidatorInterface $validator
     *
     * @return void
     */
    #[Required]
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * @param SerializerInterface $serializer
     *
     * @return void
     */
    #[Required]
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }


    /**
     * @param AMQPMessage $msg
     *
     * @return int
     */
    public function execute(AMQPMessage $msg): int
    {
        try {
            $message = $this->serializer->deserialize($msg->getBody(), $this->getMessageClass(), 'json');
            $errors = $this->validator->validate($message);

            if ($errors->count() > 0) {
                return $this->reject((string) $errors);
            }

            return $this->handle($message);
        } catch (Throwable $e) {
            var_dump($e->getMessage());
            die;
            return $this->reject($e->getMessage());
        } finally {
            $this->entityManager->clear();
            $this->entityManager->getConnection()->close();
        }
    }

    /**
     * @param string $error
     *
     * @return int
     */
    protected function reject(string $error): int
    {
        echo sprintf('Incorrect message: %s', $error);

        return self::MSG_REJECT;
    }
}
