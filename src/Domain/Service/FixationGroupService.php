<?php

namespace App\Domain\Service;

use App\Domain\Entity\Fixation;
use App\Domain\Entity\FixationGroup;
use App\Domain\Entity\Group;
use App\Infrastructure\Repository\FixationGroupRepository;

readonly class FixationGroupService
{
    /**
     * @param FixationGroupRepository $fixationGroupRepository
     */
    public function __construct(
        private FixationGroupRepository $fixationGroupRepository
    ) {
    }

    /**
     * @param Group $group
     * @param null|Fixation $fixation
     *
     * @return FixationGroup
     */
    public function build(Group $group, ?Fixation $fixation = null): FixationGroup
    {
        $fixationGroup = new FixationGroup();
        $fixationGroup->setGroup($group);
        $fixationGroup->setFixation($fixation);

        return $this->fixationGroupRepository->create($fixationGroup, false);
    }
}
