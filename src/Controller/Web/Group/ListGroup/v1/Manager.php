<?php

namespace App\Controller\Web\Group\ListGroup\v1;

use App\Application\Security\AuthUser;
use App\Controller\Web\Group\ListGroup\v1\Output\GroupListDTO;
use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;
use App\Domain\Service\UserService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\SecurityBundle\Security;

readonly class Manager
{
    /**
     * @param Security $security
     * @param UserService $userService
     * @param GroupService $groupService
     */
    public function __construct(
        private Security $security,
        private UserService $userService,
        private GroupService $groupService
    ) {
    }

    /**
     * @param AuthUser $currentUser
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function showList(AuthUser $currentUser): array
    {
        $user = $this->userService->findUserByLogin($currentUser->getUserIdentifier());
        $groupList = $this->groupService->showList(
            $user->getId(),
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
            $groupList
        )];
    }
}
