<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use RuntimeException;
use Doctrine\ORM\Query\Expr;

class GroupRepository extends AbstractRepository
{
    /**
     * @param Group $group
     *
     * @return int
     */
    public function create(Group $group): int
    {
        return $this->store($group);
    }

    /**
     * @param string $name
     *
     * @return Group|null
     * @throws RuntimeException
     */
    public function findByName(string $name): ?Group
    {
        return $this->entityManager->getRepository(Group::class)->findOneBy(['name' => $name]);
    }

    /**
     * @param int $groupId
     *
     * @return null|Group
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findGroupById(int $groupId): ?Group
    {
        return $this->entityManager->getRepository(Group::class)->find($groupId);
    }

    /**
     * @param Group $group
     *
     * @return void
     */
    public function activate(Group $group): void
    {
        $group->setIsActive(true);
        $this->flush();
    }

    /**
     * @param Group $group
     * @param User $user
     *
     * @return Group
     */
    public function addParticipant(Group $group, User $user): Group
    {
        $group->addParticipant($user);
        $this->flush();

        return $group;
    }

    /**
     * @param Group $group
     * @param User $user
     *
     * @return Group
     */
    public function removeParticipant(Group $group, User $user): Group
    {
        $group->removeParticipant($user);
        $this->flush();

        return $group;
    }

    /**
     * @param bool $ignoreIsActiveFilter
     *
     * @return array
     */
    public function getList( bool $ignoreIsActiveFilter = false): array
    {
        if ($ignoreIsActiveFilter) {
            $this->ignoreIsActiveFilter();
        }

        return $this->entityManager->getRepository(Group::class)->findAll();
    }

    /**
     * @param int $userId
     * @param bool $ignoreIsActiveFilter
     * @param int $page
     *
     * @return array
     */
    public function getListWithIsParticipant(int $userId, bool $ignoreIsActiveFilter = false, int $page = 1): array
    {
        if ($ignoreIsActiveFilter) {
            $this->ignoreIsActiveFilter();
        }

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select(['g'])
            ->addSelect('CASE WhEN gp.id=:userId THEN true ELSE false END as HIDDEN isParticipant')
            ->from(Group::class, 'g')
            ->leftJoin('g.participants', 'gp')
            ->setParameter(':userId', $userId)
            ->orderBy('isParticipant', 'DESC')
            ->addOrderBy('g.id', 'DESC')
            ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->ignoreIsActiveFilter();

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Group::class, 'g')
            ->where($queryBuilder->expr()->eq('g.id', ':id'))
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->flush();
    }

    /**
     * @return void
     */
    private function ignoreIsActiveFilter(): void
    {
        $filters = $this->entityManager->getFilters();

        if ($filters->isEnabled('is_active_filter')) {
            $filters->disable('is_active_filter');
        }
    }
}
