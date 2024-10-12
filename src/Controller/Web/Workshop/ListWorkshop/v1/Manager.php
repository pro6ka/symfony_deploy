<?php

namespace App\Controller\Web\Workshop\ListWorkshop\v1;

use App\Controller\Web\Workshop\ListWorkshop\v1\Output\ListWorkshopDTO;
use App\Controller\Web\Workshop\ListWorkshop\v1\Output\ListWorkshopItemDTO;
use App\Controller\Web\Workshop\ListWorkshop\v1\Output\ListWorkshopAuthorDTO;
use App\Domain\Entity\WorkShop;
use App\Domain\Model\PaginationModel;
use App\Domain\Model\Workshop\ListWorkshopModel;
use App\Domain\Service\WorkShopService;

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
     * @param int $page
     *
     * @return ListWorkshopDTO
     */
    public function showList(int $page): ListWorkshopDTO
    {
        $paginator = $this->workShopService->getList($page);
        $workshopList = [];

        /** @var WorkShop $workshop */
        foreach ($paginator as $workshop) {
            $workshopList[] = new ListWorkshopItemDTO(
                id: $workshop->getId(),
                title: $workshop->getTitle(),
                description: $workshop->getDescription(),
                author: new ListWorkshopAuthorDTO(
                    id: $workshop->getAuthor()->getId(),
                    firstName: $workshop->getAuthor()->getFirstName(),
                    lastName: $workshop->getAuthor()->getLastName(),
                )
            );
        }

        return new ListWorkshopDTO(
            workshopList: $workshopList,
            pagination: new PaginationModel(
                total: $paginator->count(),
                page: $page,
                pageSize: ListWorkshopModel::PAGE_SIZE
            )
        );
    }
}
