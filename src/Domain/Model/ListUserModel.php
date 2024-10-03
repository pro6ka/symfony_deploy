<?php

namespace App\Domain\Model;

readonly class ListUserModel
{
    public const int PAGE_SIZE = 10;

    public function __construct(
        public array $userList,
        public int $total,
        public int $page,
        public int $pageSize
    ) {
    }
}
