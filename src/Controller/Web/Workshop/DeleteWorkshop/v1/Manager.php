<?php

namespace App\Controller\Web\Workshop\DeleteWorkshop\v1;

use App\Domain\Entity\WorkShop;
use App\Domain\Service\WorkShopService;

readonly class Manager
{
    /**
     * @param WorkShopService $workShopService
     */
    public function __construct(
        private WorkShopService $workShopService
    ) {
    }

    /**
     * @param WorkShop $workShop
     *
     * @return void
     */
    public function deleteWorkshop(WorkShop $workShop): void
    {
        $this->workShopService->deleteWorkshop($workShop);
    }
}
