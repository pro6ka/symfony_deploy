<?php

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use RuntimeException;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserService
{
    /**
     * @param ValidatorInterface $validator
     * @param UserRepository $userRepository
     */
    public function __construct(
        private ValidatorInterface $validator,
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
        $user->setFirstName($userModel->firstName);
        $user->setLastName($userModel->lastName);
        $user->setMiddleName($userModel->middleName);
        $user->setEmail($userModel->email);
        $user->setUserRole($userModel->userRole);

        $violations = $this->validator->validate($user);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($user, $violations);
        }

        $this->userRepository->create($user);

        return $user;
    }

    /**
     * @param string $login
     *
     * @return array
     * @throws RuntimeException
     */
    public function findByLogin(string $login): array
    {
        return $this->userRepository->findByLogin($login)?->toArray() ?? [];
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws RuntimeException
     */
    public function findById(int $id): array
    {
        return $this->userRepository->findById($id)?->toArray() ?? [];
    }

    /**
     * @param string $email
     *
     * @return array
     */
    public function findByEmail(string $email): array
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
