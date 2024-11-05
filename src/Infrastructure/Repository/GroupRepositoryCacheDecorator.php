<?php

namespace App\Infrastructure\Repository;

use App\Domain\DTO\PaginationDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Repository\Group\GroupRepositoryCacheInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

readonly class GroupRepositoryCacheDecorator implements GroupRepositoryCacheInterface
{
    public function __construct(
        private GroupRepository $groupRepository,
        private CacheItemPoolInterface $cacheItemPool,
        private TagAwareCacheInterface $tagAwareCache
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
        $this->cacheItemPool->deleteItem($this->getCacheKey($user->getId()));

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
        $this->cacheItemPool->deleteItem($this->getCacheKey($user->getId()));

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getList(PaginationDTO $paginationDTO, bool $ignoreIsActiveFilter): Paginator
    {
//        return $this->cacheItemPool->
    }

    /**
     * @inheritDoc
     */
    public function getListWithIsParticipant(
        int $userId,
        PaginationDTO $paginationDTO,
        bool $ignoreIsActiveFilter = false
    ): Paginator {
        // TODO: Implement getListWithIsParticipant() method.
    }

    /**
     * @return string
     */
    private function getCacheTag(): string
    {
        return 'group_list';
    }

    /**
     * @param int $userId
     *
     * @return string
     */
    private function getCacheKey(int $userId): string
    {
        return 'group_list_' . $userId;
    }
}
