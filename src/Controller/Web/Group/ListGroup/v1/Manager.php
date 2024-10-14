<?php

namespace App\Controller\Web\Group\ListGroup\v1;

use App\Controller\Web\Group\ListGroup\v1\Output\GroupListDTO;
use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;

readonly class Manager
{
    /**
     * @param GroupService $groupService
     */
    public function __construct(
        private GroupService $groupService
    ) {
    }

    /**
     * @return array
     */
    public function showList(): array
    {
        return ['groups' => array_map(
            function (Group $group) {
                return new GroupListDTO(
                    id: $group->getId(),
                    name: $group->getName(),
                    isActive: $group->getIsActive(),
                    createdAt: $group->getCreatedAt(),
                    updatedAt: $group->getUpdatedAt(),
                    participants: $group->getParticipants()->count()
                );
            },
            $this->groupService->showList()
        )];
    }
}
