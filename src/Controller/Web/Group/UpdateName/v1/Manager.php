<?php

namespace App\Controller\Web\Group\UpdateName\v1;

use App\Controller\Web\Group\UpdateName\v1\Input\UpdateGroupNameDTO;
use App\Controller\Web\Group\UpdateName\v1\Output\UpdatedGroupDTO;
use App\Domain\Model\Group\UpdateGroupNameModel;
use App\Domain\Service\GroupService;
use App\Domain\Service\ModelFactory;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param ModelFactory $modelFactory
     * @param GroupService $groupService
     */
    public function __construct(
        private ModelFactory $modelFactory,
        private GroupService $groupService
    ) {
    }

    /**
     * @param int $id
     * @param UpdateGroupNameDTO $updateGroupNameDTO
     *
     * @return UpdatedGroupDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateName(int $id, UpdateGroupNameDTO $updateGroupNameDTO): UpdatedGroupDTO
    {
        $group = $this->groupService->updateName($this->modelFactory->makeModel(
            UpdateGroupNameModel::class,
            $id,
            $updateGroupNameDTO->name
        ));

        if (! $group) {
            throw new NotFoundHttpException(sprintf('Group id: %d not found', $updateGroupNameDTO->id));
        }

        return new UpdatedGroupDTO(
            id: $group->getId(),
            name: $group->getName(),
            isActive: $group->getIsActive(),
            createdAt: $group->getCreatedAt(),
            updatedAt: $group->getUpdatedAt(),
            participants: $group->getParticipants()->count()
        );
    }
}
