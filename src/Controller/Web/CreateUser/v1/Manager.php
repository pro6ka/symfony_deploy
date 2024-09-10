<?php

namespace App\Controller\Web\CreateUser\v1;

use App\Controller\Web\CreateUser\v1\Input\CreateUserDTO;
use App\Controller\Web\CreateUser\v1\Output\CreatedUserDTO;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\UserService;

class Manager
{
    public function __construct(private readonly UserService $userService)
    {}

    public function create(CreateUserDTO $createUserDTO): CreatedUserDTO
    {
        $userModel = new CreateUserModel(
            login: $createUserDTO->login,
            firstName: $createUserDTO->firstName,
            lastName: $createUserDTO->lastName,
            email: $createUserDTO->email,
            middleName: $createUserDTO->middleName
        );
        $user = $this->userService->create($userModel);

        return new CreatedUserDTO(
            id: $user->getId(),
            login: $user->getLogin(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            email: $user->getEmail(),
            createdAt: $user->getCreatedAt(),
            middleName: $user->getMiddleName(),
        );
    }
}
