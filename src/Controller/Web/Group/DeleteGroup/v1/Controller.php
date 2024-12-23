<?php

namespace App\Controller\Web\Group\DeleteGroup\v1;

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
     * @param int $id
     *
     * @return JsonResponse
     */
    #[Route(
        path: 'api/v1/group/{id}',
        name: 'group_delete',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(int $id): JsonResponse
    {
        $this->manager->deleteGroup($id);

        return new JsonResponse(['success' => true]);
    }
}
