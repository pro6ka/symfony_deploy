<?php

namespace App\Domain\Service;

readonly class GroupBuildService
{
    /**
     * @param GroupService $groupService
     * @param UserService $userService
     */
    public function __construct(
        private GroupService $groupService,
        private UserService $userService
    ) {
    }

    /**
     * @param int $groupId
     * @param int $userId
     *
     * @return null|array
     */
    public function addParticipant(int $groupId, int $userId): ?array
    {
        $group = $this->groupService->find($groupId);

        if (! $group) {
            return null;
        }

        $user = $this->userService->find($userId);

        if (! $user) {
            return $group->toArray();
        }

        return $this->groupService->addParticipant($group, $user);
    }
}
