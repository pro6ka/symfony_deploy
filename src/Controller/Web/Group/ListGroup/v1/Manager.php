<?php

namespace App\Controller\Web\Group\ListGroup\v1;

use App\Controller\Web\Group\ListGroup\v1\Output\GroupListDTO;
use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\SecurityBundle\Security;

readonly class Manager
{
    /**
     * @param Security $security
     * @param GroupService $groupService
     */
    public function __construct(
        private Security $security,
        private GroupService $groupService
    ) {
    }

    /**
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function showList(): array
    {
        $groupList = $this->groupService->showList(
            $this->security->isGranted('ROLE_GROUP_EDITOR'),
            $this->security->isGranted('ROLE_VIEW_GROUP')
        );

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
