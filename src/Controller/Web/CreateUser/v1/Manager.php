<?php

namespace App\Controller\Web\CreateUser\v1;

use App\Controller\Web\CreateUser\v1\Input\CreateUserDTO;
use App\Controller\Web\CreateUser\v1\Output\CreatedUserDTO;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;

class Manager
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly UserService $userService
    ) {
    }

    public function create(CreateUserDTO $createUserDTO): CreatedUserDTO
    {
        $createUserModel = $this->modelFactory->makeModel(
            CreateUserModel::class,
            $createUserDTO->login,
            $createUserDTO->firstName,
            $createUserDTO->lastName,
            $createUserDTO->email,
            $createUserDTO->middleName,
            $createUserDTO->userRole,
        );

        $user = $this->userService->create($createUserModel);

        return new CreatedUserDTO(
            id: $user->getId(),
            login: $user->getLogin(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            email: $user->getEmail(),
            createdAt: $user->getCreatedAt(),
            middleName: $user->getMiddleName(),
            userRole: $user->getUserRole()
        );
    }
}
