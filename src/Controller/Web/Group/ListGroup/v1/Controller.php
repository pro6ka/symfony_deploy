<?php

namespace App\Controller\Web\Group\ListGroup\v1;

use App\Application\Security\AuthUser;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

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
     * @param AuthUser $currentUser
     *
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route(path: 'api/v1/group', name: 'group_list', methods: ['GET']),]
    public function __invoke(#[CurrentUser] AuthUser $currentUser): JsonResponse
    {
        return new JsonResponse($this->manager->showList($currentUser));
    }
}
