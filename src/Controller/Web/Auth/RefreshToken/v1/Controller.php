<?php

namespace App\Controller\Web\Auth\RefreshToken\v1;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    /**
     * @param Manager $manager
     */
    public function __construct(
        private readonly Manager $manager
    ) {}

    /**
     * @return JsonResponse
     * @throws JWTEncodeFailureException
     * @throws RandomException
     */
    #[Route(path: 'api/v1/refresh-token', methods: ['POST'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['token' => $this->manager->refreshToken($this->getUser())]);
    }
}
