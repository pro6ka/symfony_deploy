<?php

namespace App\Controller\Web\Group\DeleteGroup\v1;

use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;

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
     * @return void
     */
    public function deleteGroup(int $groupId): void
    {
        $this->groupService->delete($groupId);
    }
}
