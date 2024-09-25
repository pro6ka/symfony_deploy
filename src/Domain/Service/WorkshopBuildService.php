<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use Doctrine\ORM\NonUniqueResultException;

readonly class WorkshopBuildService
{
    public function __construct(
        private FixationService $fixationService,
        private WorkShopService $workShopService,
        private RevisionService $revisionService
    ) {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function start(WorkShop $workShop, User $user, Group $group)
    {
        if ($groupFixation = $this->fixationService->hasGroupFixation($group, $workShop)) {
            $revision = $groupFixation->getRevision();
        } else {
            $revision = $this->revisionService->findLastForEntity($workShop);
        }

        return $this->fixationService->create($workShop, $user, $revision, $group);
    }
}
