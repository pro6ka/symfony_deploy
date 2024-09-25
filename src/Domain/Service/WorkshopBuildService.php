<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use Doctrine\ORM\NonUniqueResultException;

readonly class WorkshopBuildService
{
    /**
     * @param FixationService $fixationService
     * @param WorkShopService $workShopService
     * @param RevisionService $revisionService
     */
    public function __construct(
        private FixationService $fixationService,
        private WorkShopService $workShopService,
        private RevisionService $revisionService
    ) {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function start(WorkShop $workShop, User $user, Group $group): int
    {
        if ($groupFixation = $this->fixationService->hasGroupFixation($group, $workShop)) {
            $workshopRevision = $groupFixation->getRevision();
        } else {
            $workshopRevision = $this->revisionService->findLastForEntity($workShop);
        }

        $workShopFixation = $this->fixationService->createNoFlush($workShop, $user, $workshopRevision, $group);
    }
}
