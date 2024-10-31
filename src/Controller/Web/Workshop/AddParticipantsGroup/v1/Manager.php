<?php

namespace App\Controller\Web\Workshop\AddParticipantsGroup\v1;

use App\Controller\Web\WorkShop\AddParticipantsGroup\v1\Input\AddParticipantsGroupDTO;
use App\Controller\Web\Workshop\AddParticipantsGroup\v1\Output\Part\GroupParticipantsDTO;
use App\Controller\Web\Workshop\AddParticipantsGroup\v1\Output\WorkshopGroupsAddedDTO;
use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param WorkShopService $workShopService
     * @param GroupService $groupService
     */
    public function __construct(
        private WorkShopService $workShopService,
        private GroupService $groupService
    ) {
    }

    /**
     * @param AddParticipantsGroupDTO $participantsGroupDTO
     *
     * @return WorkshopGroupsAddedDTO
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function addParticipantsGroup(AddParticipantsGroupDTO $participantsGroupDTO): WorkshopGroupsAddedDTO
    {
        $group = $this->groupService->findGroupById($participantsGroupDTO->groupId);

        if (! $group) {
            throw new BadRequestHttpException(sprintf('Group id: %d not found', $participantsGroupDTO->groupId));
        }

        $workshop = $this->workShopService->findWorkshopById($participantsGroupDTO->workshopId);

        if (! $workshop) {
            throw new BadRequestHttpException(sprintf('Workshop id: %d not found', $participantsGroupDTO->groupId));
        }

        $workshop = $this->workShopService->addWorkshopParticipantsGroup(
            $workshop,
            $group
        );

        return new WorkshopGroupsAddedDTO(
            id: $workshop->getId(),
            title: $workshop->getTitle(),
            description: $workshop->getDescription(),
            createdAt: $workshop->getCreatedAt(),
            updatedAt: $workshop->getUpdatedAt(),
            groups: $workshop->getGroupsParticipants()->map(function (Group $group) {
                return new GroupParticipantsDTO(
                    id: $group->getId(),
                    name: $group->getName(),
                    participants: $group->getParticipants()->count()
                );
            })->toArray()
        );
    }
}
