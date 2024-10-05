<?php

namespace App\Controller\Web\CreateUser\v1;

use App\Controller\Web\CreateUser\v1\Input\CreateUserDTO;
use App\Controller\Web\CreateUser\v1\Output\CreatedUserDTO;
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
     * @param CreateUserDTO $createUserDTO
     *
     * @return JsonResponse
     */
    #[Route(path: 'api/v1/user', name: 'user_create', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateUserDTO $createUserDTO): JsonResponse
    {
        return new JsonResponse($this->manager->create($createUserDTO));
    }
}
