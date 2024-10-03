<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\ListUserItemModel;
use App\Domain\Model\ListUserModel;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use RuntimeException;

class UserRepository extends AbstractRepository
{
    /**
     * @param User $user
     * @return int
     */
    public function create(User $user): int
    {
        return $this->store($user);
    }

    /**
     * @param int $id
     *
     * @return null|User
     * @throws RuntimeException
     */
    public function findById(int $id): ?User
    {
        return $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $id]);
    }

    /**
     * @param string $login
     *
     * @return null|User
     * @throws RuntimeException
     */
    public function findByLogin(string $login): ?User
    {
        $criteria = new Criteria();
        $criteria->andWhere(Criteria::expr()?->eq('login', $login));
        $repository =  $this->entityManager->getRepository(User::class);

        return $repository->matching($criteria)->first();
    }

    /**
     * @param string $email
     *
     * @return array
     */
    public function findByEmail(string $email): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->andWhere($queryBuilder->expr()->eq('u.email', ':email'))
            ->setParameter('email', $email);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int $id
     *
     * @return null|User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function find(int $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    /**
     * @param User $user
     * @param Group $group
     *
     * @return void
     */
    public function addGroup(User $user, Group $group): void
    {
        $user->addGroup($group);
        $group->addParticipant($user);
        $this->flush();
    }

    public function getList(int $page, int $pageSize, int $firstResult = 0)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ;
        $paginator = new Paginator($queryBuilder->getQuery());
        $total = $paginator->count();

//        $queryBuilder->getQuery()->setFirstResult($pageSize * ($page - 1))
        $queryBuilder->getQuery()->setFirstResult($firstResult)
            ->setMaxResults($pageSize)
            ;

        return new ListUserModel(
            userList: $queryBuilder->getQuery()->getResult(),
            total: $total,
            page: $page,
            pageSize: ListUserModel::PAGE_SIZE
        );
    }
}
