<?php

namespace App\Controller\Web\Auth\RefreshToken\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    public function __construct(
        private Manager $manager
    ) {}

    #[Route(path: 'api/v1/refresh-token', methods: ['POST'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['token' => $this->manager->refreshToken($this->getUser())]);
    }
}