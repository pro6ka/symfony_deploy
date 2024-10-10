<?php

namespace App\Application\Security;

use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\UnAuthorizedException;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class JWTAuthenticator extends AbstractAuthenticator
{
    /**
     * @param JWTEncoderInterface $JWTEncoder
     */
    public function __construct(
        private readonly JWTEncoderInterface $JWTEncoder
    ) {}

    /**
     * @inheritDoc
     */
    public function supports(Request $request): ?bool
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws AuthenticationException
     * @throws JWTDecodeFailureException
     * @throws UnAuthorizedException
     */
    public function authenticate(Request $request): Passport
    {
        $extractor = new AuthorizationHeaderTokenExtractor('Bearer', 'Authorization');
        $token = $extractor->extract($request);

        if ($token === null) {
            throw new UnAuthorizedException();
        }

        $tokenData = $this->JWTEncoder->decode($token);

        if (! isset($tokenData['username'])) {
            throw new UnAuthorizedException();
        }

        return new SelfValidatingPassport(
            new UserBadge($tokenData['username'], fn () => new AuthUser($tokenData))
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
