<?php

namespace App\Controller\Web\Group\ListGroup\v1\Output;

use App\Controller\Web\Group\ListGroup\v1\Output\Part\GroupListItemDTO;
use App\Domain\Model\PaginationModel;

readonly class GroupListDTO
{
    /**
     * @param array|GroupListItemDTO[] $groupList
     * @param PaginationModel $pagination
     */
    public function __construct(
        public array $groupList,
        public PaginationModel $pagination
    ) {
    }
}
