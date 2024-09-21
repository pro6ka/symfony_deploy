<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Contracts\EntityInterface;
use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Fixation;
use App\Domain\Entity\Group;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class FixationRepository extends AbstractRepository
{
    /**
     * @param Fixation $fixation
     * @param bool $isImmediately
     *
     * @return void
     */
    public function create(Fixation $fixation, bool $isImmediately = false): void
    {
        $this->entityManager->persist($fixation);

        if ($isImmediately) {
            $this->entityManager->flush();
        }
    }

    /**
     * @param Group $group
     * @param EntityInterface $entity
     *
     * @return void
     */
    public function hasGroupFixation(Group $group, EntityInterface $entity): void
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('f')
            ->from(Fixation::class, 'f')
            ->andWhere($queryBuilder->expr()->eq('f.group', ':groupId'))
            ->andWhere($queryBuilder->expr()->eq('f.entityId', ':entityId'))
            ->andWhere($queryBuilder->expr()->eq('f.entityType', ':entityType'))
            ->setParameter('groupId', $group->getId())
            ->setParameter('entityId', $entity->getId())
            ->setParameter('entityType', $entity::class)
        ;
    }

    /**
     * @param RevisionableInterface $entity
     *
     * @return void
     */
    public function removeByEntity(RevisionableInterface $entity): void
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Fixation::class, 'f')
            ->andWhere($queryBuilder->expr()->eq('f.entityId', ':entityId'))
            ->andWhere($queryBuilder->expr()->eq('f.entityType', ':entityType'))
            ->setParameter('entityId', $entity->getId())
            ->setParameter('entityType', $entity::class)
            ;
        $queryBuilder->getQuery()->execute();
    }

    /**
     * @param HasFixationsInterface $owner
     *
     * @return void
     */
    public function removeByOwner(HasFixationsInterface $owner): void
    {
        $tableName = $this->entityManager->getClassMetadata($owner::class)->getTableName();
        $sql = <<<SQL
select f.id
from public.fixation f
    right join public.fixation_{$tableName} fu on fu.fixation_id=f.id
    left join public.$tableName u on fu.{$tableName}_id=u.id
where fu.{$tableName}_id=:{$tableName}Id
SQL;
        $mappingBuilder = new ResultSetMappingBuilder($this->entityManager);
        $mappingBuilder->addRootEntityFromClassMetadata(Fixation::class, 'f');
        $query = $this->entityManager->createNativeQuery($sql, $mappingBuilder);
        $query->setParameter($tableName . 'Id', $owner->getId());
        $ownersFixations = $query->getResult(AbstractQuery::HYDRATE_ARRAY);

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Fixation::class, 'f')
            ->andWhere('id in (:ids)')
            ->setParameter('ids', array_column($ownersFixations, 'id'))
        ;
        $queryBuilder->getQuery()->execute();
    }
}
