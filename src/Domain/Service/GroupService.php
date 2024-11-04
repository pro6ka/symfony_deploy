<?php

namespace App\Domain\Service;

use App\Domain\DTO\Group\GroupListInputDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\Group\CreateGroupModel;
use App\Domain\Model\Group\UpdateGroupNameModel;
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
        $group = $this->groupRepository->findGroupById($groupId);

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
    public function findGroupById(int $groupId): ?Group
    {
        return $this->groupRepository->findGroupById($groupId);
    }

    /**
     * @param Group $group
     * @param User $user
     *
     * @return Group
     */
    public function addParticipant(Group $group, User $user): Group
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
     * @param GroupListInputDTO $groupListInputDTO
     *
     * @return array
     */
    public function showList(GroupListInputDTO $groupListInputDTO): array
    {
        if ($groupListInputDTO->isWithParticipant) {
            return $this->showListWithIsParticipant($groupListInputDTO);
        }

        return $this->groupRepository->getList($groupListInputDTO->ignoreIsActiveFilter);
    }

    /**
     * @param GroupListInputDTO $groupListInputDTO
     *
     * @return array
     */
    public function showListWithIsParticipant(GroupListInputDTO $groupListInputDTO): array
    {
        return $this->groupRepository->getListWithIsParticipant(
            $groupListInputDTO->userId,
            $groupListInputDTO->ignoreIsActiveFilter,
            $groupListInputDTO->page
        );
    }

    /**
     * @param int $groupId
     *
     * @return void
     */
    public function delete(int $groupId): void
    {
        $this->groupRepository->delete($groupId);
    }

    /**
     * @param UpdateGroupNameModel $updateGroupNameModel
     *
     * @return Group|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateName(UpdateGroupNameModel $updateGroupNameModel): ?Group
    {
        $group = $this->groupRepository->findGroupById($updateGroupNameModel->id);
        $group->setName($updateGroupNameModel->name);

        $violations = $this->validator->validate($group);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($group, $violations);
        }

        $this->groupRepository->update();

        return $group;
    }
}
