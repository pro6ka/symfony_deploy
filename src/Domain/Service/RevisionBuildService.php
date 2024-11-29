<?php

namespace App\Domain\Service;

use App\Domain\Contract\FixableModelInterface;
use App\Domain\Entity\Contracts\FixableInterface;
use App\Domain\Entity\Fixation;
use App\Domain\Entity\Group;
use App\Domain\Entity\Revision;
use App\Domain\Model\Group\GroupModel;

class RevisionBuildService
{
    /**
     * @param FixationService $fixationService
     * @param RevisionService $revisionService
     */
    public function __construct(
        readonly private FixationService $fixationService,
        readonly private RevisionService $revisionService,
    ) {
    }

    /**
     * @param GroupModel $group
     * @param FixableModelInterface $entity
     *
     * @return array|Revision[]
     */
    public function buildRevisions(GroupModel $group, FixableModelInterface $entity): array
    {
        if ($groupFixation = $this->fixationService->hasGroupFixation($group, $entity)) {
            return array_map(
                fn (Fixation $fixation) => $fixation->getRevisions(),
                $groupFixation
            );
        }

        return $this->revisionService->findLastForEntity($entity);
    }
}
