<?php

namespace App\Controller\Web\Group\CreateGroup\v1;

use App\Controller\Web\Group\CreateGroup\v1\Input\CreateGroupDTO;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
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
     * @param CreateGroupDTO $createGroupDTO
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route(path: 'api/v1/group', name: 'group_create', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateGroupDTO $createGroupDTO): JsonResponse
    {
        return new JsonResponse($this->manager->createGroup($createGroupDTO));
    }
}
