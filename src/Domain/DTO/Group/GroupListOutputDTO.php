<?php

namespace App\Domain\DTO\Group;

use App\Domain\Entity\Group;
use App\Domain\Model\PaginationModel;

readonly class GroupListOutputDTO
{
    /**
     * @param array|Group[] $groupList
     * @param PaginationModel $pagination
     */
    public function __construct(
        public array $groupList,
        public PaginationModel $pagination
    ) {
    }
}
