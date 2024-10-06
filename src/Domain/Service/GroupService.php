<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\Group\CreateGroupModel;
use App\Infrastructure\Repository\GroupRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class GroupService
{
    /**
     * @param GroupRepository $groupRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private GroupRepository $groupRepository,
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @param CreateGroupModel $groupModel
     *
     * @return Group
     */
    public function create(CreateGroupModel $groupModel): Group
    {
        $group = new Group();
        $group->setName($groupModel->name);
        $group->setIsActive($groupModel->isActive);
        $group->setWorkingFrom($groupModel->workingFrom);
        $group->setWorkingTo($groupModel->workingTo);

        $violations = $this->validator->validate($group);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($group, $violations);
        }

        $this->groupRepository->create($group);

        return $group;
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

        if (!$group instanceof Group) {
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

    /**
     * @param Group $group
     * @param User $user
     *
     * @return Group
     */
    public function removeParticipant(Group $group, User $user): Group
    {
        return $this->groupRepository->removeParticipant($group, $user);
    }

    /**
     * @return array
     */
    public function showList(): array
    {
        return $this->groupRepository->getList();
    }
}
