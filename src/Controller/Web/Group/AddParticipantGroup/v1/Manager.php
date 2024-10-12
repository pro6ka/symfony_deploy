<?php

namespace App\Controller\Web\Group\AddParticipantGroup\v1;

use App\Controller\Web\Group\AddParticipantGroup\v1\Output\GroupParticipantDTO;
use App\Controller\Web\Group\AddParticipantGroup\v1\Output\GroupParticipantsUpdatedDTO;
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
        private UserService $userService
    ) {
    }

    /**
     * @param int $groupId
     * @param int $userId
     *
     * @return GroupParticipantsUpdatedDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addParticipant(int $groupId, int $userId): GroupParticipantsUpdatedDTO
    {
        if (!$user = $this->userService->find($userId)) {
            throw new NotFoundHttpException(sprintf('User id: %d not found.', $userId));
        }

        if (!$group = $this->groupService->find($groupId)) {
            throw new NotFoundHttpException(sprintf('Group id: %d not found.', $groupId));
        }

        $group = $this->groupService->addParticipant($group, $user);

        return new GroupParticipantsUpdatedDTO(
            id: $group->getId(),
            name: $group->getName(),
            isActive: $group->getIsActive(),
            createdAt: $group->getCreatedAt(),
            updatedAt: $group->getUpdatedAt(),
            participants: $group->getParticipants()->map(
                function (User $user) {
                    return new GroupParticipantDTO(
                        id: $user->getId(),
                        firstName: $user->getFirstName(),
                        lastName: $user->getLastName(),
                        middleName: $user->getMiddleName()
                    );
                },
            )->toArray()
        );
    }
}
