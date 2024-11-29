<?php

namespace App\Controller\Web\User\ShowUser\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
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
    ) {
    }

    /**
     * @param $userId
     *
     * @return JsonResponse
     */
    #[Route(path: 'api/v1/user/{userId}', name: 'user_show', requirements: ['userId' => '\d+'], methods: ['GET'])]
    public function __invoke($userId): JsonResponse
    {
        return new JsonResponse($this->manager->show($userId));
    }
}
