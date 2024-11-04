<?php

namespace App\Controller\Web\Group\ListGroup\v1;

use App\Application\Security\AuthUser;
use App\Controller\Web\Group\ListGroup\v1\Output\GroupListDTO;
use App\Domain\DTO\Group\GroupListInputDTO;
use App\Domain\Entity\Group;
use App\Domain\Model\Group\ListGroupModel;
use App\Domain\Model\PaginationModel;
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
     * @param int $page
     * @param AuthUser $currentUser
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function showList(int $page, AuthUser $currentUser): array
    {
        $user = $this->userService->findUserByLogin($currentUser->getUserIdentifier());
        $paginator = $this->groupService->showList(
            new GroupListInputDTO(
                userId: $user->getId(),
                ignoreIsActiveFilter: $this->security->isGranted('ROLE_GROUP_EDITOR'),
                isWithParticipant: $this->security->isGranted('ROLE_VIEW_GROUP'),
                page: $page
            )
        );

        return new GroupListDTO(
            groupList: array_map(
                function (Group $group) {
                    return new GroupListItemDTO(
                        id: $group->getId(),
                        name: $group->getName(),
                        isActive: $group->getIsActive(),
                        createdAt: $group->getCreatedAt(),
                        updatedAt: $group->getUpdatedAt(),
                        participants: $group->getParticipants()->count()
                    );
                },
                $paginator
            ),
            pagination: new PaginationModel(
                total: $paginator->count(),
                page: $page,
                pageSize: ListGroupModel::PAGE_SIZE
            )
        );
    }
}
