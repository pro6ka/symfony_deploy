<?php

namespace App\Domain\Model\Group;

use App\Domain\Model\PaginationModel;
use DateTime;

readonly class GroupListModel
{
    public const int PAGE_SIZE = 10;

    /**
     * @param array|GroupModel[] $groups
     * @param PaginationModel $pagination
     */
    public function __construct(
        /** @var GroupModel[] $groups */
        public array $groups,
        public PaginationModel $pagination
    ) {
    }
}
