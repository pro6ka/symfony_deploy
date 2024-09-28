<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr;

class WorkShopRepository extends AbstractRepository
{
    /**
     * @param User $user
     *
     * @return WorkShop[]|array
     */
    public function findForUser(User $user): array
    {
        $userGroupsList = array_map(
            fn (Group $group) => $group->getId(),
            $user->getGroups()->toArray()
        );
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select(['w', 'g'])
            ->from(WorkShop::class, 'w')
            ->join(
                'w.groupsParticipants',
                'g',
                Expr\Join::WITH,
                $queryBuilder->expr()->in('g.id', ':groupList')
            )
            ->setParameter('groupList', $userGroupsList)
        ;

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

    /**
     * @param int $id
     * @param User $user
     *
     * @return null|WorkShop
     * @throws NonUniqueResultException
     */
    public function findForUserById(int $id, User $user): ?WorkShop
    {
        $userGroupsList = array_map(
            fn (Group $group) => $group->getId(),
            $user->getGroups()->toArray()
        );
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select(['w', 'g'])
            ->from(WorkShop::class, 'w')
            ->join(
                'w.groupsParticipants',
                'g',
                Expr\Join::WITH,
                $queryBuilder->expr()->in('g.id', ':groupList')
            )
            ->andWhere($queryBuilder->expr()->eq('w.id', ':groupId'))
            ->setParameter('groupList', $userGroupsList)
            ->setParameter('groupId', $id)
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_OBJECT);
    }
}
