<?php

namespace App\Application\Security;

use App\Domain\Service\UserService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class AuthService
{
    /**
     * @param UserService $userService
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(
        private UserService $userService,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    /**
     * @param string $login
     * @param string $password
     *
     * @return bool
     */
    public function isCredentialsValid(string $login, string $password): bool
    {
        $user = $this->userService->findUserByLogin($login);

        if ($user === null) {
            return false;
        }

        return $this->passwordHasher->isPasswordValid($user, $password);
    }
}
