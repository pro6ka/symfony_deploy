<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Contracts\EntityInterface;
use App\Domain\Entity\Contracts\FixableInterface;
use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Fixation;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class FixationRepository extends AbstractRepository
{
    /**
     * @param Fixation $fixation
     * @param bool $doFlush
     *
     * @return void
     */
    public function create(Fixation $fixation, bool $doFlush = true): void
    {
        $this->entityManager->persist($fixation);

        if ($doFlush) {
            $this->entityManager->flush();
        }
    }

    /**
     * @param User $user
     * @param string $entityType
     *
     * @return ArrayCollection
     */
    public function findForUser(User $user, string $entityType): ArrayCollection
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select(['f', 'u'])
            ->from(Fixation::class, 'f')
            ->join(
                'f.user',
                'u',
                Expr\Join::WITH,
                $queryBuilder->expr()->eq('u.id', ':userId')
            )
            ->andWhere($queryBuilder->expr()->eq('f.entityType', ':entityType'))
            ->setParameter('userId', $user->getId())
            ->setParameter('entityType', $entityType)
            ;
        return new ArrayCollection($queryBuilder->getQuery()->getResult());
    }

    /**
     * @param Group $group
     * @param FixableInterface $entity
     *
     * @return Fixation|null
     * @throws NonUniqueResultException
     */
    public function hasGroupFixation(Group $group, FixableInterface $entity): ?Fixation
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select(['f', 'g'])
//        $queryBuilder->select(['f'])
            ->from(Fixation::class, 'f')
            ->innerJoin(
                'f.group',
                'g',
                Expr\Join::WITH,
                $queryBuilder->expr()->eq('g.id', ':groupId')
            )
            ->andWhere($queryBuilder->expr()->eq('f.entityId', ':entityId'))
            ->andWhere($queryBuilder->expr()->eq('f.entityType', ':entityType'))
            ->setParameter('groupId', $group->getId())
            ->setParameter('entityId', $entity->getId())
            ->setParameter('entityType', $entity::class)
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
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
