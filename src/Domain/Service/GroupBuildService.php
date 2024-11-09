<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\Group\GroupModel;
use App\Domain\Model\User\UserModel;
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
     * @return null|GroupModel
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addParticipant(int $groupId, int $userId): ?GroupModel
    {
        $group = $this->groupService->findGroupById($groupId);

        if (! $group) {
            return null;
        }

        $user = $this->userService->find($userId);

        if (! $user) {
            return $group;
        }

        $groupEntity = $this->groupService->findEntityById($groupId);
        $result = $this->groupService->addParticipant($groupEntity, $user);

        return new GroupModel(
            id: $result->getId(),
            name: $result->getName(),
            isActive: $result->getIsActive(),
            workingFrom: $result->getWorkingFrom(),
            workingTo: $result->getWorkingTo(),
            createdAt: $result->getCreatedAt(),
            updatedAt: $result->getUpdatedAt(),
            participants: $result->getParticipants()->map(fn (User $user) => [
                'id' => $user->getId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
            ])->toArray()
        );
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
