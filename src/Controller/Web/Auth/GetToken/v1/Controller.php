<?php

namespace App\Controller\Web\Auth\GetToken\v1;

use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\UnAuthorizedException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Random\RandomException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    /**
     * @param Manager $manager
     */
    public function __construct(
        private Manager $manager
    ) {}

    /**
     * @param Request $request
     *
     * @return Response
     * @throws AccessDeniedException
     * @throws UnAuthorizedException
     * @throws JWTEncodeFailureException
     */
    #[Route(path: 'api/v1/get-token', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        return new JsonResponse(['token' => $this->manager->getToken($request)]);
    }
}
