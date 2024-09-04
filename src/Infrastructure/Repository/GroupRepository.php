<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;

class GroupRepository extends AbstractRepository
{
    /**
     * @param Group $group
     *
     * @return int
     */
    public function create(Group $group): int
    {
        return $this->store($group);
    }

    /**
     * @param string $name
     *
     * @return Group|null
     */
    public function findByName(string $name): ?Group
    {
        return $this->entityManager->getRepository(Group::class)->findOneBy(['name' => $name]);
    }
}
