<?php

namespace App\Controller\Web\Workshop\RemoveParticipantsGroup\v1;

use App\Controller\Web\WorkShop\AddParticipantsGroup\v1\Input\AddParticipantsGroupDTO;
use App\Controller\Web\Workshop\AddParticipantsGroup\v1\Output\Part\GroupParticipantsDTO;
use App\Controller\Web\Workshop\RemoveParticipantsGroup\v1\Output\WorkshopGroupsUpdatedDTO;
use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;
use App\Domain\Service\WorkShopService;
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
     * @return WorkshopGroupsUpdatedDTO
     */
    public function removeParticipantsGroup(AddParticipantsGroupDTO $participantsGroupDTO): WorkshopGroupsUpdatedDTO
    {
        if (! $group = $this->groupService->findEntityById($participantsGroupDTO->groupId)) {
            throw new NotFoundHttpException(sprintf('Group id: %d not found', $participantsGroupDTO->groupId));
        }

        if (! $workshop = $this->workShopService->findEntityById($participantsGroupDTO->workshopId)) {
            throw new NotFoundHttpException(sprintf('Workshop id: %d not found', $participantsGroupDTO->groupId));
        }

        $workshop = $this->workShopService->removeWorkshopParticipantsGroup($workshop, $group);

        return new WorkshopGroupsUpdatedDTO(
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
