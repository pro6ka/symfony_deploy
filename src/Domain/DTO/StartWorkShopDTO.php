<?php

namespace App\Domain\DTO;

readonly class StartWorkShopDTO
{
    /**
     * @param int $workShopId
     * @param int $userId
     * @param int $groupId
     */
    public function __construct(
        public int $workShopId,
        public int $userId,
        public int $groupId
    ) {
    }
}
