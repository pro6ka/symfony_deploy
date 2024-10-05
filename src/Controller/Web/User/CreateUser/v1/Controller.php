<?php

namespace App\Controller\Web\User\CreateUser\v1;

use App\Controller\Web\User\CreateUser\v1\Input\CreateUserDTO;
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
