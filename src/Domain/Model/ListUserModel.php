<?php

namespace App\Domain\Model;

use App\Controller\Web\ListUser\v1\Output\ListUserItemDTO;

readonly class ListUserModel
{
    public const int PAGE_SIZE = 5;

    /**
     * @param array|ListUserItemDTO[] $userList
     * @param int $total
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(
        public array $userList,
        public int $total,
        public int $page,
        public int $pageSize = self::PAGE_SIZE
    ) {
    }
}
