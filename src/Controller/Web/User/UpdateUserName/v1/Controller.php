<?php

namespace App\Controller\Web\UpdateUserName\v1;

use App\Controller\Web\UpdateUserName\v1\Input\UserNameDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private Manager $manager)
    {
    }

    #[Route(path: 'api/v1/user/update-name', methods: ['POST'])]
    public function updateUserName(#[MapRequestPayload] UserNameDTO $userNameDTO): JsonResponse
    {
        return new JsonResponse($this->manager->updateUserName($userNameDTO));
    }
}
