<?php

namespace App\Controller\Web\ListUser\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(
        private Manager $manager
    ) {
    }

    #[Route(path: 'api/v1/user/{page}', name: 'user_list', requirements: ['page' => '\d+'], methods: ['GET'])]
    public function __invoke($page = 1)
    {
        return new JsonResponse($this->manager->getList($page));
    }
}
