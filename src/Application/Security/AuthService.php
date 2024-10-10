<?php

namespace App\Application\Security;

use App\Domain\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Random\RandomException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class AuthService
{
    /**
     * @param UserService $userService
     * @param UserPasswordHasherInterface $passwordHasher
     * @param JWTEncoderInterface $JWTEncoder
     * @param int $tokenTTL
     */
    public function __construct(
        private UserService $userService,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTEncoderInterface $JWTEncoder,
        private int $tokenTTL
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
     * @throws JWTEncodeFailureException
     */
    public function getToken(string $login): ?string
    {
        $user = $this->userService->findUserByLogin($login);
        $tokenData = [
            'username' => $login,
            'roles' => $user?->getRoles() ?? [],
            'exp' => time() + $this->tokenTTL,
        ];

        return $this->JWTEncoder->encode($tokenData);
    }
}
