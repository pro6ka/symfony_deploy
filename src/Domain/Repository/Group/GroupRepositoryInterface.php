<?php

namespace App\Domain\Repository\Group;

use App\Domain\Entity\Group;

interface GroupRepositoryInterface
{
    /**
     * @param int $groupId
     *
     * @return null|Group
     */
    public function findGroupById(int $groupId): ?Group;

    /**
     * @return void
     */
    public function update(): void;
}
