<?php

namespace App\Controller\Web\User\UpdateUserName\v1;

use App\Controller\Web\User\UpdateUserName\v1\Input\UserNameDTO;
use App\Controller\Web\User\UpdateUserName\v1\Output\UpdatedUserDTO;
use App\Domain\Model\User\UpdateUserNameModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param UserService $userService
     * @param ModelFactory $modelFactory
     */
    public function __construct(
        private UserService $userService,
        private ModelFactory $modelFactory,
    ) {
    }

    /**
     * @param UserNameDTO $userNameDTO
     *
     * @return UpdatedUserDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateUserName(UserNameDTO $userNameDTO): UpdatedUserDTO
    {
        $updatedUser = $this->userService->updateUserName($this->modelFactory->makeModel(
            UpdateUserNameModel::class,
            $userNameDTO->id,
            $userNameDTO->firstName,
            $userNameDTO->lastName,
            $userNameDTO->middleName
        ));

        if (! $updatedUser) {
            throw new NotFoundHttpException(sprintf('User id: %d not found', $userNameDTO->id));
        }

        return new UpdatedUserDTO(
            id: $updatedUser->getId(),
            login: $updatedUser->getLogin(),
            firstName: $updatedUser->getFirstname(),
            lastName: $updatedUser->getLastName(),
            email: $updatedUser->getEmail(),
            createdAt: $updatedUser->getCreatedAt(),
            updatedAt: $updatedUser->getUpdatedAt(),
            middleName: $updatedUser->getMiddleName(),
            userRole: $updatedUser->getUserRole(),
        );
    }
}
