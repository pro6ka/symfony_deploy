<?php

namespace App\Application\Security;

use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\UnAuthorizedException;
use App\Domain\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiTokenAuthenticator extends AbstractAuthenticator
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws UnAuthorizedException
     */
    public function authenticate(Request $request): Passport
    {
        $authorization = $request->headers->get('Authorization');
        $token = str_starts_with($authorization, 'Bearer ') ? substr($authorization, 7) : null;

        if ($token === null) {
            throw new UnAuthorizedException();
        }

        return new SelfValidatingPassport(
            new UserBadge($token, fn ($token) => $this->userService->findUserByToken($token))
        );
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): ?Response {
        return null;
    }

    /**
     * @inheritDoc
     * @throws AccessDeniedException
     */
    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ): ?Response {
        throw new AccessDeniedException();
    }
}
