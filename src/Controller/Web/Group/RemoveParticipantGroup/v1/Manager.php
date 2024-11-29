<?php

namespace App\Controller\Web\Group\RemoveParticipantGroup\v1;

use App\Controller\Web\Group\RemoveParticipantGroup\v1\Output\GroupParticipantsRemovedDTO;
use App\Controller\Web\Group\RemoveParticipantGroup\v1\Output\Part\GroupParticipantDTO;
use App\Domain\Entity\User;
use App\Domain\Service\GroupService;
use App\Domain\Service\UserService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param GroupService $groupService
     * @param UserService $userService
     */
    public function __construct(
        private GroupService $groupService,
        private UserService $userService,
    ) {
    }

    /**
     * @param int $groupId
     * @param int $userId
     *
     * @return GroupParticipantsRemovedDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeParticipant(int $groupId, int $userId): GroupParticipantsRemovedDTO
    {
        if (! $user = $this->userService->find($userId)) {
            throw new NotFoundHttpException(sprintf('User id: %d not found.', $userId));
        }

        if (! $group = $this->groupService->findEntityById($groupId)) {
            throw new NotFoundHttpException(sprintf('Group id: %d not found.', $groupId));
        }

        $group = $this->groupService->removeParticipant($group, $user);

        return new GroupParticipantsRemovedDTO(
            id: $group->getId(),
            name: $group->getName(),
            isActive: $group->getIsActive(),
            createdAt: $group->getCreatedAt(),
            updatedAt: $group->getUpdatedAt(),
            participants: $group->getParticipants()->map(function (User $user) {
                return new GroupParticipantDTO(
                    id: $user->getId(),
                    firstName: $user->getFirstName(),
                    lastName: $user->getLastName(),
                    middleName: $user->getMiddleName()
                );
            })->toArray()
        );
    }
}
