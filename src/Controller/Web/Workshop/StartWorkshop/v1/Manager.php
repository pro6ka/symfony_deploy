<?php

namespace App\Controller\Web\Workshop\StartWorkshop\v1;

use App\Controller\Web\Workshop\StartWorkshop\v1\Input\StartWorkshopDTO;
use App\Domain\Service\GroupService;
use App\Domain\Service\UserService;
use App\Domain\Service\WorkshopBuildService;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class Manager
{
    /**
     * @param WorkShopService $workShopService
     * @param WorkshopBuildService $workshopBuildService
     * @param UserService $userService
     * @param GroupService $groupService
     */
    public function __construct(
        private WorkShopService $workShopService,
        private WorkshopBuildService $workshopBuildService,
        private UserService $userService,
        private GroupService $groupService
    ) {
    }

    /**
     * @param StartWorkshopDTO $startWorkshopDTO
     * @param UserInterface $authUser
     *
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function startWorkshop(StartWorkshopDTO $startWorkshopDTO, UserInterface $authUser): bool
    {
        if (! $group = $this->groupService->findGroupById($startWorkshopDTO->groupId)) {
            throw new BadRequestHttpException(sprintf('Group id: %d not found', $startWorkshopDTO->groupId));
        }

        if (! $workshop = $this->workShopService->findWorkshopById($startWorkshopDTO->workshopId)) {
            throw new BadRequestHttpException(sprintf('Workshop id: %d not found', $startWorkshopDTO->workshopId));
        }

        if (! $this->workshopBuildService->isWorkShopReadyToStart($workshop)) {
            throw new BadRequestHttpException(sprintf('Workshop id: %d is not ready', $startWorkshopDTO->workshopId));
        }

        $user = $this->userService->findUserByLogin($authUser->getUserIdentifier());

        $this->workshopBuildService->startAsync($workshop, $user, $group);

        return true;
    }
}
