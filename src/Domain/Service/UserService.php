<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use RuntimeException;

readonly class UserService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * @param string $login
     *
     * @return array
     */
    public function create(string $login): array
    {
        $user = new User();
        $user->setLogin($login);
        $user->setEmail(preg_replace('~\s~', '.', $login) . '@email.dvl.to');
        $user->setFirstName($login . 's First Name');
        $user->setLastName($login . 's Last Name');
        $this->userRepository->create($user);

        return $user->toArray();
    }

    /**
     * @param string $login
     *
     * @return array
     * @throws RuntimeException
     */
    public function findUserByLogin(string $login): array
    {
        return $this->userRepository->findByLogin($login)?->toArray() ?? [];
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws RuntimeException
     */
    public function findUserById(int $id): array
    {
        return $this->userRepository->findById($id)?->toArray() ?? [];
    }

    /**
     * @param string $email
     *
     * @return array
     */
    public function findUserByEmail(string $email): array
    {
        return $this->userRepository->findByEmail($email);
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
        return $this->userRepository->find($id);
    }
}
