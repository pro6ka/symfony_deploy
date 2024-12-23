<?php

namespace App\Controller\Web\User\ShowUser\v1;

use App\Controller\Web\User\ShowUser\v1\Output\ShowUserDTO;
use App\Domain\Service\UserService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        private UserService $userService
    ) {
    }

    /**
     * @param int $userId
     *
     * @return ShowUserDTO
     */
    public function show(int $userId): ShowUserDTO
    {
        $user = $this->userService->findById($userId);
        if (! $user) {
            throw new NotFoundHttpException(sprintf('User with id:%d not found', $userId));
        }

        return new ShowUserDTO(
            id: $user->getId(),
            login: $user->getLogin(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            middleName: $user->getMiddleName(),
            email: $user->getEmail(),
            createdAt: $user->getCreatedAt(),
            updatedAt: $user->getUpdatedAt(),
            userRole: $user->getUserRole()
        );
    }
}
