<?php

namespace App\Domain\Model\User;

use App\Controller\Web\User\ListUser\v1\Output\ListUserItemDTO;
use App\Domain\Model\PaginationModel;

readonly class ListUserModel
{
    public const int PAGE_SIZE = 5;

    /**
     * @param array|UserModel[] $userList
     * @param PaginationModel $pagination
     */
    public function __construct(
        public array $userList,
        public PaginationModel $pagination
    ) {
    }
}
