<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Exercise;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Model\Exercise\ExerciseModel;
use App\Domain\Model\User\WorkShopAuthorModel;
use App\Domain\Model\Workshop\WorkShopModel;
use App\Domain\Repository\WorkShop\WorkShopRepositoryCacheInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Psr\Cache\CacheItemPoolInterface;

readonly class WorkShopRepositoryCacheDecorator implements WorkShopRepositoryCacheInterface
{
    /**
     * @param CacheItemPoolInterface $cacheItemPool
     * @param WorkShopRepository $workShopRepository
     */
    public function __construct(
        private CacheItemPoolInterface $cacheItemPool,
        private WorkShopRepository $workShopRepository
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
     * @inheritDoc
     */
    public function findForUserById(int $id, User $user): ?WorkShop
    {
        $workShopItem = $this->cacheItemPool->getItem(
            $this->getCacheKey($id, $user->getId())
        );

        if (! $workShopItem->isHit()) {
            $workshop = $this->workShopRepository->findForUserById($id, $user);
            $workShopItem->set(new WorkShopModel(
                id: $workshop->getId(),
                title: $workshop->getTitle(),
                description: $workshop->getDescription(),
                createdAt: $workshop->getCreatedAt(),
                updatedAt: $workshop->getUpdatedAt(),
                author: new WorkShopAuthorModel(
                    id: $workshop->getAuthor()->getId(),
                    firstName: $workshop->getAuthor()->getFirstName(),
                    lastName: $workshop->getAuthor()->getLastName(),
                    middleName: $workshop->getAuthor()->getMiddleName()
                ),
                exercises: array_map(
                    fn (Exercise $exercise) => new ExerciseModel(
                        id: $exercise->getId(),
                        title: $exercise->getTitle(),
                        content: $exercise->getContent(),
                        questions: $exercise->getQuestions()->count()
                    ),
                    $workshop->getExercises()->toArray()
                )
            ));
            $this->cacheItemPool->save($workShopItem);
        }

        return $workShopItem->get();
    }

    /**
     * @param int $id
     *
     * @return null|WorkShop
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $id): ?WorkShop
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
