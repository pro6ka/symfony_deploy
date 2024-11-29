<?php

namespace App\Domain\Service;

use App\Domain\Entity\Fixation;
use App\Domain\Entity\FixationGroup;
use App\Domain\Entity\Group;
use App\Domain\Model\Group\GroupModel;
use App\Infrastructure\Repository\FixationGroupRepository;

class FixationGroupService
{
    /**
     * @param GroupService $groupService
     * @param FixationGroupRepository $fixationGroupRepository
     */
    public function __construct(
        readonly private GroupService $groupService,
        readonly private FixationGroupRepository $fixationGroupRepository
    ) {
    }

    /**
     * @param GroupModel $group
     * @param null|Fixation $fixation
     *
     * @return FixationGroup
     */
    public function build(GroupModel $group, ?Fixation $fixation = null): FixationGroup
    {
        $groupEntity = $this->groupService->findEntityById($group->id);
        $fixationGroup = new FixationGroup();
        $fixationGroup->setGroup($groupEntity);
        $fixationGroup->setFixation($fixation);

        return $this->fixationGroupRepository->create($fixationGroup, false);
    }
}
