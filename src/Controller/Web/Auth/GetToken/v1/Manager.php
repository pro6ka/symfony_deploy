<?php

namespace App\Controller\Web\Auth\GetToken\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\UnAuthorizedException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Component\HttpFoundation\Request;

readonly class Manager
{
    /**
     * @param AuthService $authService
     */
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * @param Request $request
     *
     * @return string
     * @throws AccessDeniedException
     * @throws UnAuthorizedException
     * @throws JWTEncodeFailureException
     */
    public function getToken(Request $request): string
    {
        $user = $request->getUser();
        $password = $request->getPassword();

        if (! $user || ! $password) {
            throw new UnAuthorizedException();
        }

        if (! $this->authService->isCredentialsValid($user, $password)) {
            throw new AccessDeniedException();
        }

        return $this->authService->getToken($user);
    }
}
