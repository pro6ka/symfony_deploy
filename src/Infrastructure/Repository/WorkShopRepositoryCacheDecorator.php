<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Factory\WorkShopModelFactory;
use App\Domain\Model\Workshop\WorkShopModel;
use App\Domain\Repository\WorkShop\WorkShopRepositoryCacheInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

readonly class WorkShopRepositoryCacheDecorator implements WorkShopRepositoryCacheInterface
{
    /**
     * @param CacheItemPoolInterface $cacheItemPool
     * @param WorkShopRepository $workShopRepository
     * @param WorkShopModelFactory $workShopModelFactory
     */
    public function __construct(
        private CacheItemPoolInterface $cacheItemPool,
        private WorkShopRepository $workShopRepository,
        private WorkShopModelFactory $workShopModelFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function findForUser(User $user): array
    {
        return $this->workShopRepository->findForUser($user);
    }

    /**
     * @inheritDoc
     */
    public function create(WorkShop $workShop): int
    {
        return $this->workShopRepository->create($workShop);
    }

    /**
     * @param int $id
     * @param User $user
     *
     * @return null|WorkShopModel
     * @throws InvalidArgumentException
     */
    public function findForUserById(int $id, User $user): ?WorkShopModel
    {
        $workShopItem = $this->cacheItemPool->getItem(
            $this->getCacheKey($id, $user->getId())
        );

        if (! $workShopItem->isHit()) {
            $workshop = $this->workShopRepository->findForUserById($id, $user);
            if (! $workshop) {
                return null;
            }
            $workShopItem->set($this->workShopModelFactory->fromEntity($workshop));
            $this->cacheItemPool->save($workShopItem);
        }

        return $workShopItem->get();
    }

    /**
     * @param int $id
     *
     * @return null|WorkShopModel
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $id): ?WorkShopModel
    {
        return $this->workShopRepository->findById($id)
            ? $this->workShopModelFactory->fromEntity($this->workShopRepository->findById($id))
            : null;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function findEntityById(int $id): ?WorkShop
    {
        return $this->workShopRepository->findById($id);
    }

    /**
     * @inheritDoc
     */
    public function getList(int $pageSize, int $firstResult = 0): Paginator
    {
        return $this->workShopRepository->getList($pageSize, $firstResult);
    }

    /**
     * @inheritDoc
     */
    public function removeWorkshop(WorkShop $workshop): void
    {
        $this->workShopRepository->removeWorkshop($workshop);
    }

    /**
     * @inheritDoc
     */
    public function addParticipantsGroup(WorkShop $workShop, Group $group): WorkShop
    {
        return $this->workShopRepository->addParticipantsGroup($workShop, $group);
    }

    /**
     * @inheritDoc
     */
    public function removeParticipantsGroup(WorkShop $workShop, Group $group): WorkShop
    {
        return $this->workShopRepository->removeParticipantsGroup($workShop, $group);
    }

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function flushForStartedCache($workShopId, $userId): void
    {
        $this->cacheItemPool->deleteItem($this->getCacheKey($workShopId, $userId));
    }

    /**
     * @inheritDoc
     */
    public function update(): void
    {
        $this->workShopRepository->update();
    }

    /**
     * @param int $workShopId
     * @param int $userId
     *
     * @return string
     */
    private function getCacheKey(int $workShopId, int $userId): string
    {
        return 'workshop_' . $workShopId . '_for_user_' . $userId;
    }
}
