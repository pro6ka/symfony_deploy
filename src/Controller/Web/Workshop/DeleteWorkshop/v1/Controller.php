<?php

namespace App\Controller\Web\Workshop\DeleteWorkshop\v1;

use App\Domain\Entity\WorkShop;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
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
     * @param WorkShop $workShop
     *
     * @return JsonResponse
     */
    #[Route(path: 'api/v1/workshop/{id}', name: 'workshop_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(#[MapEntity(id: 'id')] WorkShop $workShop): JsonResponse
    {
        $this->manager->deleteWorkshop($workShop);

        return new JsonResponse(['success' => true]);
    }
}
