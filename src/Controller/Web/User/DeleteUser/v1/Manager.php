<?php

namespace App\Controller\Web\DeleteUser\v1;

use App\Domain\Entity\User;
use App\Domain\Service\UserService;

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
     * @param User $user
     *
     * @return void
     */
    public function deleteUser(User $user): void
    {
        $this->userService->remove($user);
    }
}
