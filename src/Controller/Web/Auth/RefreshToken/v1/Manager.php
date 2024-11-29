<?php

namespace App\Controller\Web\Auth\RefreshToken\v1;

use App\Application\Security\AuthService;
use App\Domain\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Random\RandomException;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class Manager
{
    /**
     * @param AuthService $authService
     * @param UserService $userService
     */
    public function __construct(
        private AuthService $authService,
        private UserService $userService
    ) {
    }

    /**
     * @param UserInterface $user
     *
     * @return null|string
     * @throws JWTEncodeFailureException
     * @throws RandomException
     */
    public function refreshToken(UserInterface $user): ?string
    {
        $this->userService->clearUserToken($user->getUserIdentifier());

        return $this->authService->getToken($user->getUserIdentifier());
    }
}
