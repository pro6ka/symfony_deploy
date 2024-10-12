<?php

namespace App\Controller\Web\User\LeaveGroup\v1;

use App\Controller\Web\User\LeaveGroup\v1\Input\UserLeaveGroupDTO;
use App\Controller\Web\User\LeaveGroup\v1\Output\GroupItemDTO;
use App\Controller\Web\User\LeaveGroup\v1\Output\UserGroupsDTO;
use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;
use App\Domain\Service\UserService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param UserService $userService
     * @param GroupService $groupService
     */
    public function __construct(
        private UserService $userService,
        private GroupService $groupService
    ) {
    }

    /**
     * @param UserLeaveGroupDTO $userLeaveGroupDTO
     *
     * @return UserGroupsDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function leaveGroup(UserLeaveGroupDTO $userLeaveGroupDTO): UserGroupsDTO
    {
        if (! $group = $this->groupService->findGroupById($userLeaveGroupDTO->groupId)) {
            throw new NotFoundHttpException(sprintf('Group with id: %d not found', $userLeaveGroupDTO->groupId));
        }

        if (! $user = $this->userService->leaveGroup($userLeaveGroupDTO->userId, $group)) {
            throw new NotFoundHttpException(sprintf('User with id: %d not found', $userLeaveGroupDTO->userId));
        }

        $this->groupService->removeParticipant($group, $user);

        return new UserGroupsDTO(
            id: $user->getId(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            email: $user->getEmail(),
            groups: array_map(
                function (Group $group) {
                    return new GroupItemDTO(
                        id: $group->getId(),
                        name: $group->getName()
                    );
                },
                $user->getGroups()->toArray()
            )
        );
    }
}
