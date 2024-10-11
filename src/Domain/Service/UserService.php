<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\User\CreateUserModel;
use App\Domain\Model\User\ListUserModel;
use App\Domain\Model\User\UpdateUserNameModel;
use App\Domain\Trait\PaginationTrait;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Random\RandomException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserService
{
    use PaginationTrait;

    /**
     * @param ValidatorInterface $validator
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param UserRepository $userRepository
     */
    public function __construct(
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepository $userRepository
    ) {
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
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $userModel->password));
        $user->setFirstName($userModel->firstName);
        $user->setLastName($userModel->lastName);
        $user->setMiddleName($userModel->middleName);
        $user->setEmail($userModel->email);
        $user->setUserRole($userModel->userRole);
        $user->setAppRoles($userModel->appRoles);

        $violations = $this->validator->validate($user);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($user, $violations);
        }

        $this->userRepository->create($user);

        return $user;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function remove(User $user): void
    {
        $this->userRepository->removeUser($user);
    }

    /**
     * @param int $id
     *
     * @return null|User
     */
    public function findById(int $id): ?User
    {
        return $this->userRepository->findById($id);
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

    /**
     * @param int $page
     *
     * @return Paginator
     */
    public function getList(int $page): Paginator
    {
        return $this->userRepository->getList(
            pageSize: ListUserModel::PAGE_SIZE,
            firstResult: $this->countPageSize(page: $page, pageSize: ListUserModel::PAGE_SIZE)
        );
    }

    /**
     * @param UpdateUserNameModel $userNameModel
     *
     * @return User|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateUserName(UpdateUserNameModel $userNameModel): ?User
    {
        return $this->userRepository->updateUsername($userNameModel);
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
        return $this->userRepository->leaveGroup($userId, $group);
    }

    /**
     * @param string $login
     *
     * @return null|User
     */
    public function findUserByLogin(string $login): ?User
    {
        $users = $this->userRepository->findUserByLogin($login);

        return $users[0];
    }

    /**
     * @param string $login
     *
     * @return null|string
     * @throws RandomException
     */
    public function updateUserToken(string $login): ?string
    {
        $user = $this->findUserByLogin($login);

        if ($user === null) {
            return null;
        }

        return $this->userRepository->updateUserToken($user);
    }

    /**
     * @param string $token
     *
     * @return null|User
     */
    public function findUserByToken(string $token): ?User
    {
        return $this->userRepository->findUserByToken($token);
    }

    /**
     * @param string $login
     *
     * @return void
     */
    public function clearUserToken(string $login): void
    {
        $user = $this->findUserByLogin($login);

        if ($user !== null) {
            $this->userRepository->clearUserToken($user);
        }
    }
}
