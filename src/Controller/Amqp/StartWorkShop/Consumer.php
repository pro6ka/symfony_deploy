<?php

namespace App\Controller\Amqp\StartWorkShop;

use App\Application\RabbitMQ\AbstractConsumer;
use App\Controller\Amqp\StartWorkShop\Input\Message;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Exception\GroupIsNotWorkshopParticipantException;
use App\Domain\Service\GroupService;
use App\Domain\Service\UserService;
use App\Domain\Service\WorkshopBuildService;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Consumer extends AbstractConsumer
{
    /**
     * @param WorkShopService $workShopService
     * @param UserService $userService
     * @param GroupService $groupService
     * @param WorkshopBuildService $workshopBuildService
     */
    public function __construct(
        private readonly WorkShopService $workShopService,
        private readonly UserService $userService,
        private readonly GroupService $groupService,
        private readonly WorkshopBuildService $workshopBuildService
    ) {
    }

    /**
     * @return string
     */
    public function getMessageClass(): string
    {
        return Message::class;
    }

    /**
     * @param Message $message
     *
     * @return int
     * @throws ContainerExceptionInterface
     * @throws GroupIsNotWorkshopParticipantException
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle($message): int
    {
        $workshop = $this->workShopService->findWorkshopById($message->workShopId);

        if (! ($workshop instanceof WorkShop)) {
            $this->reject(sprintf('Workshop ID %d was not found', $message->workShopId));
        }

        $user = $this->userService->findById($message->userId);

        if (! ($user instanceof  User)) {
            $this->reject(sprintf('User ID %d was not found', $message->userId));
        }

        $group = $this->groupService->findGroupById($message->groupId);

        if (! ($group instanceof Group)) {
            $this->reject(sprintf('Group ID %d was not found', $message->groupId));
        }

        $this->workshopBuildService->start($workshop, $user, $group);

        return self::MSG_ACK;
    }
}
