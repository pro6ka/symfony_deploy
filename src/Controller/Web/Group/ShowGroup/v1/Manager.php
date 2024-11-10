<?php

namespace App\Controller\Web\Group\ShowGroup\v1;

use App\Controller\Web\Group\ShowGroup\v1\Output\Part\ShowGroupParticipantDTO;
use App\Controller\Web\Group\ShowGroup\v1\Output\ShowGroupDTO;
use App\Domain\Entity\User;
use App\Domain\Service\GroupService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @param int $groupId
     *
     * @return ShowGroupDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function show(int $groupId): ShowGroupDTO
    {
        if ($group = $this->groupService->findGroupById($groupId)) {
            return new ShowGroupDTO(
                id: $group->id,
                name: $group->name,
                isActive: $group->isActive,
                createdAt: $group->createdAt,
                updatedAt: $group->updatedAt,
                participants: array_map(
                    function (User $participant) {
                        return new ShowGroupParticipantDTO(
                            id: $participant->getId(),
                            firstName: $participant->getFirstName(),
                            lastName: $participant->getLastName(),
                            middleName: $participant->getMiddleName()
                        );
                    },
                    $group->participants
                )
            );
        }

        throw new NotFoundHttpException(sprintf('Group id: %d not found', $groupId));
    }
}
