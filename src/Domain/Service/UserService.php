<?php

namespace App\Domain\Service;

use App\Controller\Web\CreateUser\v1\Output\CreatedUserDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
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
     * @param CreateUserModel $userModel
     *
     * @return User
     */
    public function create(CreateUserModel $userModel): User
    {
        $user = new User();
        $user->setLogin($userModel->login);
        $user->setFirstName($userModel->firstName);
        $user->setLastName($userModel->lastName);
        $user->setMiddleName($userModel->middleName);
        $user->setEmail($userModel->email);
        $this->userRepository->create($user);

        return $user;
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
