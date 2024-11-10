<?php

namespace App\Domain\Service;

use App\Domain\DTO\Group\GroupListInputDTO;
use App\Domain\DTO\PaginationDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\Group\CreateGroupModel;
use App\Domain\Model\Group\GroupListModel;
use App\Domain\Model\Group\GroupModel;
use App\Domain\Model\Group\UpdateGroupNameModel;
use App\Domain\Repository\Group\GroupRepositoryCacheInterface;
use App\Domain\Trait\PaginationTrait;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class GroupService
{
    use PaginationTrait;

    /**
     * @param GroupRepositoryCacheInterface $groupRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private GroupRepositoryCacheInterface $groupRepository,
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
     * @return null|GroupModel
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findGroupById(int $groupId): ?GroupModel
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
     * @return GroupListModel
     * @throws Exception
     */
    public function showList(GroupListInputDTO $groupListInputDTO): GroupListModel
    {
        $paginationDTO = new PaginationDTO(
            pageSize: GroupListModel::PAGE_SIZE,
            page: $groupListInputDTO->page,
            firstResult: $this->countOffset($groupListInputDTO->page, GroupListModel::PAGE_SIZE),
        );

        $violations = $this->validator->validate($paginationDTO);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($paginationDTO, $violations);
        }

        if ($groupListInputDTO->isWithParticipant) {
            return $this->showListWithIsParticipant($paginationDTO, $groupListInputDTO);
        }

        return $this->groupRepository->getList($paginationDTO, $groupListInputDTO->ignoreIsActiveFilter);
    }

    /**
     * @param PaginationDTO $paginationDTO
     * @param GroupListInputDTO $groupListInputDTO
     *
     * @return GroupListModel
     * @throws Exception
     */
    public function showListWithIsParticipant(
        PaginationDTO $paginationDTO,
        GroupListInputDTO $groupListInputDTO
    ): GroupListModel {
        return $this->groupRepository->getListWithIsParticipant(
            $groupListInputDTO->userId,
            $paginationDTO,
            $groupListInputDTO->ignoreIsActiveFilter
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
     */
    public function updateName(UpdateGroupNameModel $updateGroupNameModel): ?Group
    {
        $group = $this->groupRepository->findById($updateGroupNameModel->id);
        $group->setName($updateGroupNameModel->name);

        $violations = $this->validator->validate($group);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($group, $violations);
        }

        $this->groupRepository->update();

        return $group;
    }

    /**
     * @param int $id
     *
     * @return null|Group
     */
    public function findEntityById(int $id): ?Group
    {
        return $this->groupRepository->findById($id);
    }
}
