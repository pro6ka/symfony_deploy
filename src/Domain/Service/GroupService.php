<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\GroupRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

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
     * @throws ORMException
     * @throws OptimisticLockException
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

    /**
     * @param int $groupId
     *
     * @return null|Group
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function find(int $groupId): ?Group
    {
        return $this->groupRepository->find($groupId);
    }

    /**
     * @param Group $group
     * @param User $user
     *
     * @return array
     */
    public function addParticipant(Group $group, User $user): array
    {
        return $this->groupRepository->addParticipant($group, $user);
    }
}
