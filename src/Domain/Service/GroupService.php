<?php

namespace App\Domain\Service;

use App\Domain\DTO\Group\GroupListOutputDTO;
use App\Domain\DTO\Group\GroupListInputDTO;
use App\Domain\DTO\PaginationDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\Group\CreateGroupModel;
use App\Domain\Model\Group\ListGroupModel;
use App\Domain\Model\Group\UpdateGroupNameModel;
use App\Domain\Model\PaginationModel;
use App\Domain\Repository\Group\GroupRepositoryCacheInterface;
use App\Domain\Repository\Group\GroupRepositoryInterface;
use App\Domain\Trait\PaginationTrait;
use App\Infrastructure\Repository\GroupRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class GroupService
{
    use PaginationTrait;

    /**
     * @param GroupRepository $groupRepository
     * @param GroupRepositoryCacheInterface $groupRepositoryCache
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private GroupRepositoryInterface $groupRepository,
        private GroupRepositoryCacheInterface $groupRepositoryCache,
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
     * @return GroupListOutputDTO
     * @throws Exception
     */
    public function showList(GroupListInputDTO $groupListInputDTO): GroupListOutputDTO
    {
        $paginationDTO = new PaginationDTO(
            pageSize: ListGroupModel::PAGE_SIZE,
            firstResult: $this->countOffset($groupListInputDTO->page, ListGroupModel::PAGE_SIZE),
        );

        $violations = $this->validator->validate($paginationDTO);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($paginationDTO, $violations);
        }

        if ($groupListInputDTO->isWithParticipant) {
            return $this->showListWithIsParticipant($paginationDTO, $groupListInputDTO);
        }

        $paginator = $this->groupRepository->getList($paginationDTO, $groupListInputDTO->ignoreIsActiveFilter);

        return new GroupListOutputDTO(
            groupList: array_map(fn (Group $group) => $group, (array) $paginator->getIterator()),
            pagination: new PaginationModel(
                total: $paginator->count(),
                page: $groupListInputDTO->page,
                pageSize: ListGroupModel::PAGE_SIZE
            )
        );
    }

    /**
     * @param PaginationDTO $paginationDTO
     * @param GroupListInputDTO $groupListInputDTO
     *
     * @return GroupListOutputDTO
     * @throws Exception
     */
    public function showListWithIsParticipant(
        PaginationDTO $paginationDTO,
        GroupListInputDTO $groupListInputDTO
    ): GroupListOutputDTO {
        $paginator = $this->groupRepositoryCache->getListWithIsParticipant(
            $groupListInputDTO->userId,
            $paginationDTO,
            $groupListInputDTO->ignoreIsActiveFilter
        );

        return new GroupListOutputDTO(
            groupList: array_map(fn (ListGroupModel $group) => $group, $paginator),
            pagination: new PaginationModel(
                total: $paginator->count(),
                page: $groupListInputDTO->page,
                pageSize: ListGroupModel::PAGE_SIZE
            )
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
