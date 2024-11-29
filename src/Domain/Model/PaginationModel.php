<?php

namespace App\Domain\Model;

readonly class PaginationModel
{
    /**
     * @param int $total
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(
        public int $total,
        public int $page,
        public int $pageSize
    ) {
    }
}
