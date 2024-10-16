<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Contracts\FixableInterface;
use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Fixation;
use App\Domain\Entity\Group;
use App\Domain\Entity\Revision;
use App\Domain\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use RuntimeException;

class FixationRepository extends AbstractRepository
{
    /**
     * @param Fixation $fixation
     * @param bool $doFlush
     *
     * @return Fixation
     */
    public function create(Fixation $fixation, bool $doFlush = true): Fixation
    {
        $this->entityManager->persist($fixation);

        if ($doFlush) {
            $this->flush();
        }

        return $fixation;
    }

    /**
     * @param Fixation $fixation
     * @param bool $doFlush
     *
     * @return void
     */
    public function drop(Fixation $fixation, bool $doFlush = true): void
    {
        if ($doFlush) {
            $this->remove($fixation);
        } else {
            $this->entityManager->remove($fixation);
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
            ->setParameter('entityType', $entityType);
        return new ArrayCollection($queryBuilder->getQuery()->getResult());
    }

    /**
     * @param Group $group
     * @param FixableInterface $entity
     *
     * @return array|Fixation[]
     */
    public function hasGroupFixation(Group $group, FixableInterface $entity): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select(['f', 'g'])
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
            ->setParameter('entityType', $entity::class);

        return $queryBuilder->getQuery()->getResult();
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
            ->setParameter('entityType', $entity::class);
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
    right join public.fixation_ . $tableName fu on fu.fixation_id=f.id
    left join public.$tableName u on fu.{$tableName}_id=u.id
where fu.{$tableName}_id=:{$tableName}Id
SQL;
        $mappingBuilder = new ResultSetMappingBuilder($this->entityManager);
        $mappingBuilder->addRootEntityFromClassMetadata(Fixation::class, 'f');
        $query = $this->entityManager->createNativeQuery($sql, $mappingBuilder);
        $query->setParameter($tableName . 'Id', $owner->getId());
        $ownersFixations = $query->getResult(AbstractQuery::HYDRATE_ARRAY);

        if (! $ownersFixations) {
            return;
        }

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Fixation::class, 'f')
            ->andWhere('id in (:ids)')
            ->setParameter('ids', array_column($ownersFixations, 'id'));

        $queryBuilder->getQuery()->execute();
    }

    /**
     * @param FixableInterface $entity
     * @param User $user
     * @param Revision $revision
     * @param Group $group
     *
     * @return null|Fixation
     * @throws RuntimeException
     */
    public function findByFullCriteria(
        FixableInterface $entity,
        User $user,
        Revision $revision,
        Group $group
    ): ?Fixation {
        if (!$entity->getId()) {
            dump($entity);
            die;
        }
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select(['f', 'u', 'r'])
            ->from(Fixation::class, 'f')
            ->andWhere($queryBuilder->expr()->eq('f.entityId', ':entityId'))
            ->andWhere($queryBuilder->expr()->eq('f.entityType', ':entityType'))
            ->leftJoin(
                'f.revisions',
                'r',
                Expr\Join::WITH,
                $queryBuilder->expr()->eq('r.id', ':revisionId')
            )
            ->innerJoin(
                'f.user',
                'u',
                Expr\Join::WITH,
                $queryBuilder->expr()->eq('u.id', ':userId')
            )
            ->innerJoin(
                'f.group',
                'g',
                Expr\Join::WITH,
                $queryBuilder->expr()->eq('g.id', ':groupId')
            )
            ->setParameter('entityId', $entity->getId())
            ->setParameter('entityType', $entity::class)
            ->setParameter('revisionId', $revision->getId())
            ->setParameter('userId', $user->getId())
            ->setParameter('groupId', $group->getId());

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param string $entityType
     * @param int $entityId
     * @param int $userId
     * @param int $groupId
     *
     * @return array
     */
    public function listForUserByEntity(
        string $entityType,
        int $entityId,
        int $userId,
        int $groupId
    ): array {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('f')
            ->from(Fixation::class, 'f')
            ->andWhere($queryBuilder->expr()->eq('f.entityType', ':entityType'))
            ->andWhere($queryBuilder->expr()->eq('f.entityId', ':entityId'))
            ->leftJoin(
                'f.user',
                'u',
                Expr\Join::WITH,
                $queryBuilder->expr()->eq('u.id', ':userId')
            )
            ->leftJoin(
                'f.group',
                'g',
                Expr\Join::WITH,
                $queryBuilder->expr()->eq('g.id', ':groupId')
            )
            ->setParameter('entityType', $entityType)
            ->setParameter('entityId', $entityId)
            ->setParameter('userId', $userId)
            ->setParameter('groupId', $groupId)
            ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param User $user
     * @param Group $group
     *
     * @return array|Fixation[]
     */
    public function findForUserByGroup(User $user, Group $group): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select(['f', 'fg', 'fu'])
            ->from(Fixation::class, 'f')
            ->innerJoin(
                'f.group',
                'fg',
                Expr\Join::WITH,
                $queryBuilder->expr()->eq('fg.group', ':groupId')
            )
            ->innerJoin(
                'f.user',
                'fu',
                Expr\Join::WITH,
                $queryBuilder->expr()->eq('fu.user', ':userId')
            )
            ->setParameter('groupId', $group->getId())
            ->setParameter('userId', $user->getId())
            ;

        return $queryBuilder->getQuery()->getResult();
    }
}
