<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Infrastructure\Repository\GroupRepository;

class GroupService
{
    public function __construct(private GroupRepository $groupRepository)
    {}

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
}
