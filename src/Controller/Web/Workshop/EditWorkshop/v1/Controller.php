<?php

namespace App\Controller\Web\Workshop\EditWorkshop\v1;

use App\Controller\Web\Workshop\EditWorkshop\v1\Input\EditWorkshopDTO;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param EditWorkshopDTO $workshopDTO
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route(
        path: 'api/v1/workshop/title-and-description-update',
        name: 'workshop_title_and_description_update',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] EditWorkshopDTO $workshopDTO): JsonResponse
    {
        return new JsonResponse($this->manager->editWorkshop($workshopDTO));
    }
}
