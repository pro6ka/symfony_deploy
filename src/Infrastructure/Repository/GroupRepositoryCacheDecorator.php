<?php

namespace App\Infrastructure\Repository;

use App\Domain\DTO\PaginationDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\Group\ListGroupModel;
use App\Domain\Repository\Group\GroupRepositoryCacheInterface;
use App\Domain\Repository\Group\GroupRepositoryInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

readonly class GroupRepositoryCacheDecorator implements GroupRepositoryCacheInterface
{
    /**
     * @param GroupRepositoryInterface $groupRepository
     * @param TagAwareCacheInterface $tagAwareCache
     */
    public function __construct(
        private GroupRepositoryInterface $groupRepository,
        private TagAwareCacheInterface $tagAwareCache,
    ) {
    }

    /**
     * @param Group $group
     *
     * @return int
     * @throws InvalidArgumentException
     */
    public function create(Group $group): int
    {
        $result = $this->groupRepository->create($group);
        $this->tagAwareCache->invalidateTags([$this->getCacheTag()]);

        return $result;
    }

    /**
     * @param Group $group
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function activate(Group $group): void
    {
        $this->groupRepository->activate($group);
        $this->tagAwareCache->invalidateTags([$this->getCacheTag()]);
    }

    /**
     * @param int $groupId
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function delete(int $groupId): void
    {
        $this->groupRepository->delete($groupId);
        $this->tagAwareCache->invalidateTags([$this->getCacheTag()]);
    }

    /**
     * @param Group $group
     * @param User $user
     *
     * @return Group
     * @throws InvalidArgumentException
     */
    public function addParticipant(Group $group, User $user): Group
    {
        $result = $this->groupRepository->addParticipant($group, $user);
        $this->tagAwareCache->invalidateTags([$this->getCacheTag($user->getId())]);

        return $result;
    }

    /**
     * @param Group $group
     * @param User $user
     *
     * @return Group
     * @throws InvalidArgumentException
     */
    public function removeParticipant(Group $group, User $user): Group
    {
        $result = $this->groupRepository->removeParticipant($group, $user);
        $this->tagAwareCache->invalidateTags([$this->getCacheTag($user->getId())]);

        return $result;
    }

    /**
     * @param PaginationDTO $paginationDTO
     * @param bool $ignoreIsActiveFilter
     *
     * @return array|ListGroupModel[]
     * @throws InvalidArgumentException
     */
    public function getList(PaginationDTO $paginationDTO, bool $ignoreIsActiveFilter): array
    {
        return $this->tagAwareCache->get(
            $this->getCacheKey($paginationDTO->firstResult),
            function (ItemInterface $item) use ($paginationDTO, $ignoreIsActiveFilter) {
                $paginator = $this->groupRepository->getList($paginationDTO, $ignoreIsActiveFilter);
                $groupModels = array_map(fn (Group $group) => new ListGroupModel(
                    id: $group->getId(),
                    name: $group->getName(),
                    isActive: $group->getIsActive(),
                    workingFrom: $group->getWorkingFrom(),
                    workingTo: $group->getWorkingTo(),
                    createdAt: $group->getCreatedAt(),
                    updatedAt: $group->getUpdatedAt()
                ), (array) $paginator->getIterator());
                $item->set($groupModels);
                $item->tag($this->getCacheTag());

                return $groupModels;
            }
        );
    }

    /**
     * @param int $userId
     * @param PaginationDTO $paginationDTO
     * @param bool $ignoreIsActiveFilter
     *
     * @return array|ListGroupModel[]
     * @throws InvalidArgumentException
     */
    public function getListWithIsParticipant(
        int $userId,
        PaginationDTO $paginationDTO,
        bool $ignoreIsActiveFilter = false
    ): array {
        return $this->tagAwareCache->get(
            $this->getCacheKey($paginationDTO->firstResult, $userId),
            function (ItemInterface $item) use ($userId, $paginationDTO, $ignoreIsActiveFilter) {
                $groups = $this->groupRepository->getListWithIsParticipant(
                    $userId,
                    $paginationDTO,
                    $ignoreIsActiveFilter
                );
                $groupModels = array_map(
                    static fn(Group $group) => new ListGroupModel(
                        id: $group->getId(),
                        name: $group->getName(),
                        isActive: $group->getIsActive(),
                        workingFrom: $group->getWorkingFrom(),
                        workingTo: $group->getWorkingTo(),
                        createdAt: $group->getCreatedAt(),
                        updatedAt: $group->getUpdatedAt()
                    ),
                    (array)$groups->getIterator()
                );
                $item->set($groupModels);
                $item->tag($this->getCacheTag($userId));

                return $groupModels;
            }
        );
    }

    /**
     * @param null|int $userId
     *
     * @return string
     */
    private function getCacheTag(?int $userId = null): string
    {
        return 'group_list' . $userId ? '_user_' . $userId : '';
    }

    /**
     * @param int $firstResult
     * @param null|int $userId
     *
     * @return string
     */
    private function getCacheKey(int $firstResult, ?int $userId = null): string
    {
        return 'group_list_page' . $firstResult . $userId ? '_user_' . $userId : '';
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function update(): void
    {
        $this->groupRepository->update();
        $this->tagAwareCache->invalidateTags([$this->getCacheTag()]);
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
}
