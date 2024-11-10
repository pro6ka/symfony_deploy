<?php

namespace App\Controller\Web\Workshop\EditWorkshop\v1;

use App\Controller\Web\Workshop\EditWorkshop\v1\Input\EditWorkshopDTO;
use App\Controller\Web\Workshop\EditWorkshop\v1\Output\EditedWorkshopDTO;
use App\Domain\Model\Workshop\EditWorkshopModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param WorkShopService $workShopService
     * @param ModelFactory $modelFactory
     */
    public function __construct(
        private WorkShopService $workShopService,
        private ModelFactory $modelFactory
    ) {
    }

    /**
     * @param EditWorkshopDTO $workshopDTO
     *
     * @return EditedWorkshopDTO
     */
    public function editWorkshop(EditWorkshopDTO $workshopDTO): EditedWorkshopDTO
    {
        $workshop = $this->workShopService->editWorkshop($this->modelFactory->makeModel(
            EditWorkshopModel::class,
            $workshopDTO->title,
            $workshopDTO->description,
        ));

        if ($workshop) {
            return new EditedWorkshopDTO(
                id: $workshop->getId(),
                title: $workshop->getTitle(),
                description: $workshop->getDescription(),
                createdAt: $workshop->getCreatedAt(),
                updatedAt: $workshop->getUpdatedAt(),
            );
        }

        throw new NotFoundHttpException(sprintf('Workshop id: %d not found', $workshopDTO->id));
    }
}
