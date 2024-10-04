<?php

namespace App\Domain\Trait;

trait PaginationTrait
{
    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return int
     */
    public function countPageSize(int $page, int $pageSize): int
    {
        return $pageSize * ($page - 1);
    }
}
