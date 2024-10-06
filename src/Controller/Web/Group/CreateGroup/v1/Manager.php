<?php

namespace App\Controller\Web\Group\CreateGroup\v1;

use App\Controller\Web\Group\CreateGroup\v1\Input\CreateGroupDTO;
use App\Controller\Web\Group\CreateGroup\v1\Output\CreatedGroupDTO;
use App\Domain\Model\Group\CreateGroupModel;
use App\Domain\Service\GroupService;
use App\Domain\Service\ModelFactory;
use DateTime;
use Exception;

readonly class Manager
{
    public function __construct(
        private ModelFactory $modelFactory,
        private GroupService $groupService
    ) {
    }

    /**
     * @throws Exception
     */
    public function createGroup(CreateGroupDTO $createGroupDTO): CreatedGroupDTO
    {
        $groupModel = $this->modelFactory->makeModel(
            CreateGroupModel::class,
            $createGroupDTO->name,
            $createGroupDTO->isActive,
            $createGroupDTO->workingFrom ? new DateTime($createGroupDTO->workingFrom) : new DateTime(),
            $createGroupDTO->workingTo ? new DateTime($createGroupDTO->workingTo) : null,
        );

        $group = $this->groupService->create($groupModel);

        return new CreatedGroupDTO(
            id: $group->getId(),
            name: $group->getName(),
            isActive: $group->getIsActive(),
            createdAt: $group->getCreatedAt(),
            updatedAt: $group->getUpdatedAt(),
            workingFrom: $group->getWorkingFrom(),
            workingTo: $group->getWorkingTo()
        );
    }
}
