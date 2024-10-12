<?php

namespace App\Controller\Web\WorkShop\AddParticipantsGroup\v1;

use App\Controller\Web\WorkShop\AddParticipantsGroup\v1\Input\AddParticipantsGroupDTO;
use App\Controller\Web\Workshop\AddParticipantsGroup\v1\Output\GroupParticipantsDTO;
use App\Controller\Web\Workshop\AddParticipantsGroup\v1\Output\WorkshopGroupsAddedDTO;
use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
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
     */
    public function addParticipantsGroup(AddParticipantsGroupDTO $participantsGroupDTO): WorkshopGroupsAddedDTO
    {
        $group = $this->groupService->findGroupById($participantsGroupDTO->groupId);

        if (! $group) {
            throw new NotFoundHttpException(sprintf('Group id: %d not found', $participantsGroupDTO->groupId));
        }

        $workshop = $this->workShopService->findWorkshopById($participantsGroupDTO->workshopId);

        if (! $workshop) {
            throw new NotFoundHttpException(sprintf('Workshop id: %d not found', $participantsGroupDTO->groupId));
        }

        $workshop = $this->workShopService->addWorkshopParticipantsGroup($workshop, $group);

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
