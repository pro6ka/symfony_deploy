<?php

namespace App\Controller\Web\Workshop\ListWorkshop\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Domain\Model\PaginationModel;

readonly class ListWorkshopDTO implements OutputDTOInterface
{
    public function __construct(
        /** @var ListWorkshopItemDTO[] */
        public array $workshopList,
        public PaginationModel $pagination
    ) {
    }
}
