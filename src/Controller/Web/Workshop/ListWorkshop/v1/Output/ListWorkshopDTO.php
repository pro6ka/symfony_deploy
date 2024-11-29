<?php

namespace App\Controller\Web\Workshop\ListWorkshop\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Controller\Web\Workshop\ListWorkshop\v1\Output\Part\ListWorkshopItemDTO;
use App\Domain\Model\PaginationModel;

readonly class ListWorkshopDTO implements OutputDTOInterface
{
    /**
     * @param array $workshopList
     * @param PaginationModel $pagination
     */
    public function __construct(
        /** @var ListWorkshopItemDTO[] */
        public array $workshopList,
        public PaginationModel $pagination
    ) {
    }
}
