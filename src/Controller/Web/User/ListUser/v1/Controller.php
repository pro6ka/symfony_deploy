<?php

namespace App\Controller\Web\User\ListUser\v1;

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
     * @param int $page
     *
     * @return JsonResponse
     */
    #[Route(path: 'api/v1/user/{page}', name: 'user_list', requirements: ['page' => '\d+'], methods: ['GET'])]
    public function __invoke(int $page = 1): JsonResponse
    {
        return new JsonResponse($this->manager->getList($page));
    }
}
