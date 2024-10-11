<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Contracts\HasRevisionsInterface;
use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Revision;

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
     * @param RevisionableInterface $entity
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
     * @return array|Revision[]
     */
    public function findLastForEntity(RevisionableInterface $entity): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('r')
            ->from(Revision::class, 'r')
            ->andWhere($queryBuilder->expr()->eq('r.entityId', ':entityId'))
            ->andWhere($queryBuilder->expr()->eq('r.entityType', ':entityType'))
            ->setParameter('entityId', $entity->getId())
            ->setParameter('entityType', $entity::class)
            ->orderBy('r.createdAt', 'DESC')
            ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param HasRevisionsInterface $entity
     *
     * @return void
     */
    public function removeByEntity(HasRevisionsInterface $entity): void
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Revision::class, 'r')
            ->andWhere($queryBuilder->expr()->eq('r.entityId', ':entityId'))
            ->andWhere($queryBuilder->expr()->eq('r.entityType', ':entityType'))
            ->setParameter('entityId', $entity->getId())
            ->setParameter('entityType', $entity::class)
            ;
        $queryBuilder->getQuery()->execute();
    }
}
