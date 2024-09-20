<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Revision;
use App\Infrastructure\Repository\AbstractRepository;

class RevisionRepository extends AbstractRepository
{
    /**
     * @param Revision $revision
     *
     * @return int
     */
    public function create(Revision $revision): int
    {
        return $this->store($revision);
    }

    /**
     * @param Revision $entity
     *
     * @return null|Revision
     */
    public function forEntityByEntityId(RevisionableInterface $entity): ?Revision
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('r')
            ->from(Revision::class, 'r')
            ->andWhere($queryBuilder->expr()->eq('r.entityId', ':entityId'))
            ->andWhere($queryBuilder->expr()->eq('r.entityType', ':entityType'))
            ->setParameter('entityId', $entity->getId())
            ->setParameter('entityType', $entity::class);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param RevisionableInterface $entity
     *
     * @return null|Revision
     */
    public function findLastForEntity(RevisionableInterface $entity): ?Revision
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('r')
            ->from(Revision::class, 'r')
            ->andWhere($queryBuilder->expr()->eq('r.entityId', ':entityId'))
            ->andWhere($queryBuilder->expr()->eq('r.entityType', ':entityType'))
            ->setParameter('entityId', $entity->getId())
            ->setParameter('entityType', $entity::class)
            ->orderBy('r.createdAt', 'DESC')
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getSingleResult();
    }
}
