<?php

namespace App\Controller\Web\Group\ListGroup\v1;

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
     * @return JsonResponse
     */
    #[Route(path: 'api/v1/group', name: 'group_list', requirements: ['id' => '\d+'], methods: ['GET']),]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->manager->showList());
    }
}
