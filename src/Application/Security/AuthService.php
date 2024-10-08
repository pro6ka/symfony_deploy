<?php

namespace App\Application\Security;

use App\Domain\Service\UserService;
use Random\RandomException;
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

    /**
     * @param string $login
     *
     * @return null|string
     * @throws RandomException
     */
    public function getToken(string $login): ?string
    {
        return $this->userService->updateUserToken($login);
    }
}
