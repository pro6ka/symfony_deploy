<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class GroupBuildService
{
    /**
     * @param GroupService $groupService
     * @param UserService $userService
     * @param FixationService $fixationService
     */
    public function __construct(
        private GroupService $groupService,
        private UserService $userService,
        private FixationService $fixationService
    ) {
    }

    /**
     * @param int $groupId
     * @param int $userId
     *
     * @return null|Group
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addParticipant(int $groupId, int $userId): ?Group
    {
        $group = $this->groupService->findGroupById($groupId);

        if (! $group) {
            return null;
        }

        $user = $this->userService->find($userId);

        if (! $user) {
            return $group;
        }

        return $this->groupService->addParticipant($group, $user);
    }

    /**
     * @param Group $group
     * @param User $user
     *
     * @return void
     */
    public function removeParticipant(Group $group, User $user): void
    {
        $this->fixationService->removeForUserByGroup($user, $group);
        $this->groupService->removeParticipant($group, $user);
    }
}
