<?php

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Domain\Model\ListUserModel;
use App\Domain\Trait\PaginationTrait;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use RuntimeException;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserService
{
    use PaginationTrait;

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
     * @return null|User
     */
    public function findById(int $id): ?User
    {
        return $this->userRepository->findById($id);
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

    /**
     * @param int $page
     *
     * @return Paginator
     */
    public function getList(int $page): Paginator
    {
        return $this->userRepository->getList(
            page: $page,
            pageSize: ListUserModel::PAGE_SIZE,
            firstResult: $this->countPageSize(page: $page, pageSize: ListUserModel::PAGE_SIZE)
        );
    }
}
