<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\User\UpdateUserNameModel;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Random\RandomException;
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
     * @param int $pageSize
     * @param int $firstResult
     *
     * @return Paginator
     */
    public function getList(int $pageSize, int $firstResult = 0): Paginator
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

    /**
     * @param User $user
     *
     * @return string
     * @throws RandomException
     */
    public function updateUserToken(User $user): string
    {
        $token = base64_encode(random_bytes(21));
        $user->setToken($token);
        $this->flush();

        return $token;
    }

    /**
     * @param string $login
     *
     * @return array
     */
    public function findUserByLogin(string $login): array
    {
        return $this->entityManager->getRepository(User::class)->findBy(['login' => $login]);
    }

    /**
     * @param string $token
     *
     * @return null|User
     */
    public function findUserByToken(string $token): ?User
    {
        /** @var User|null $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['token' => $token]);

        return $user;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function clearUserToken(User $user): void
    {
        $user->setToken(null);
        $this->flush();
    }
}
