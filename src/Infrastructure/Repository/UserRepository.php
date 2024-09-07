<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Exception\ORMException;

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
     * @throws ORMException
     */
    public function addGroup(User $user, Group $group): void
    {
        $user->addGroup($group);
        $group->addParticipant($user);
        $this->flush();
    }
}
