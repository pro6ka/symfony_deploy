<?php

namespace App\Controller\Web\Workshop\ShowWorkshop\v1;

use App\Controller\Web\Workshop\CreateWorkshop\v1\Output\WorkshopAuthorDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopAuthorDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopDTO;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param WorkShopService $workShopService
     */
    public function __construct(
        private WorkShopService $workShopService
    ) {
    }

    /**
     * @param int $workshopId
     *
     * @return ShowWorkshopDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function showWorkshop(int $workshopId): ShowWorkshopDTO
    {
        if ($workshop = $this->workShopService->findById($workshopId)) {
            return new ShowWorkshopDTO(
                id: $workshop->getId(),
                title: $workshop->getTitle(),
                description: $workshop->getDescription(),
                createdAt: $workshop->getCreatedAt(),
                updatedAt: $workshop->getUpdatedAt(),
                author: new ShowWorkshopAuthorDTO(
                    id: $workshop->getAuthor()->getId(),
                    firstName: $workshop->getAuthor()->getFirstName(),
                    lastName: $workshop->getAuthor()->getLastName()
                )
            );
        }

        throw new NotFoundHttpException(sprintf('Workshop id: %d not found', $workshopId));
    }
}
