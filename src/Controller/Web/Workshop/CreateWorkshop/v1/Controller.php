<?php

namespace App\Controller\Web\Workshop\CreateWorkshop\v1;

use App\Controller\Web\Workshop\CreateWorkshop\v1\Input\CreateWorkshopDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
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
     * @param CreateWorkshopDTO $createWorkshopDTO
     * @param UserInterface $authUser
     *
     * @return JsonResponse
     */
    #[Route(path: 'api/v1/workshop', name: 'workshop_create', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] CreateWorkshopDTO $createWorkshopDTO,
        #[CurrentUser] UserInterface $authUser
    ): JsonResponse {
        return new JsonResponse($this->manager->createWorkshop($createWorkshopDTO, $authUser));
    }
}
