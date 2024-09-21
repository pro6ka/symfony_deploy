<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Contracts\EntityInterface;
use App\Domain\Entity\Fixation;
use App\Domain\Entity\Group;

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
}
