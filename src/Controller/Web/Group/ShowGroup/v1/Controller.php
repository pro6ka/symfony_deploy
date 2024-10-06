<?php

namespace App\Controller\Web\Group\ShowGroup\v1;

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

    #[Route(path: 'api/v1/group/{id}', name: 'group_show', methods: ['GET'])]
    public function __invoke(int $id)
    {
        return new JsonResponse($this->manager->show($id));
    }
}
