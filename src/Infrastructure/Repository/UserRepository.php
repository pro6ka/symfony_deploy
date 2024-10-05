<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\User\UpdateUserNameModel;
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

    /**
     * @param int $page
     * @param int $pageSize
     * @param int $firstResult
     *
     * @return Paginator
     */
    public function getList(int $page, int $pageSize, int $firstResult = 0): Paginator
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->setFirstResult($firstResult)
            ->setMaxResults($pageSize)
            ;

        return new Paginator($queryBuilder->getQuery());
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function removeUser(User $user): void
    {
        $this->remove($user);
    }

    /**
     * @param UpdateUserNameModel $userNameModel
     *
     * @return null|User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateUserName(UpdateUserNameModel $userNameModel): ?User
    {
        $user = $this->find($userNameModel->id);
        if (! $user) {
            return null;
        }
        if ($userNameModel->firstName) {
            $user->setFirstName($userNameModel->firstName);
        }
        if ($userNameModel->lastName) {
            $user->setLastName($userNameModel->lastName);
        }
        if ($userNameModel->middleName) {
            $user->setMiddleName($userNameModel->middleName);
        }

        $this->flush();

        return $user;
    }

    /**
     * @param int $userId
     * @param Group $group
     *
     * @return null|User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function leaveGroup(int $userId, Group $group): ?User
    {
        $user = $this->entityManager->getRepository(User::class)
            ->find($userId);
        if (! $userId) {
            return null;
        }

        $user->leaveGroup($group);
        $this->flush();

        return $user;
    }
}
