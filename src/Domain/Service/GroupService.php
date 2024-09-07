<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Infrastructure\Repository\GroupRepository;

readonly class GroupService
{
    /**
     * @param GroupRepository $groupRepository
     */
    public function __construct(private GroupRepository $groupRepository)
    {
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function create(string $name): array
    {
        $group = new Group();
        $group->setName($name);
        $this->groupRepository->create($group);

        return $group->toArray();
    }

    /**
     * @param int $groupId
     *
     * @return null|Group
     */
    public function activate(int $groupId): ?Group
    {
        $group = $this->groupRepository->find($groupId);

        if (! $group instanceof Group) {
            return null;
        }

        $this->groupRepository->activate($group);

        return $group;
    }
}
