<?php

namespace App\Controller\Web\Group\ShowGroup\v1;

use App\Controller\Web\Group\ShowGroup\v1\Output\ShowGroupDTO;
use App\Controller\Web\Group\ShowGroup\v1\Output\ShowGroupParticipantDTO;
use App\Domain\Entity\User;
use App\Domain\Service\GroupService;

readonly class Manager
{
    public function __construct(
        private GroupService $groupService
    ) {
    }

    public function show(int $groupId)
    {
        if ($group = $this->groupService->find($groupId)) {
            return new ShowGroupDTO(
                id: $group->getId(),
                name: $group->getName(),
                isActive: $group->getIsActive(),
                createdAt: $group->getCreatedAt(),
                updatedAt: $group->getUpdatedAt(),
                participants: $group->getParticipants()->map(function (User $participant) {
                    return new ShowGroupParticipantDTO(
                        id: $participant->getId(),
                        firstName: $participant->getFirstname(),
                        lastName: $participant->getLastName(),
                        middleName: $participant->getMiddleName()
                    );
                })->toArray()
            );
        }
    }
}
