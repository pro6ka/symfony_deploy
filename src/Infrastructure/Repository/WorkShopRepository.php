<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\WorkShop;

class WorkShopRepository extends AbstractRepository
{
    /**
     * @param int[]|array $userGroupsList
     *
     * @return WorkShop[]|array
     */
    public function findForUserGroups(array $userGroupsList): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('w')
            ->from(WorkShop::class, 'w')
            ->andWhere($queryBuilder->expr()->in('w.groupsParticipants', ':userGroupList'))
            ->setParameter('userGroupList', $userGroupsList);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param WorkShop $workShop
     *
     * @return int
     */
    public function create(WorkShop $workShop): int
    {
        return $this->store($workShop);
    }
}
