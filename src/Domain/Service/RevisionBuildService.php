<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\FixableInterface;
use App\Domain\Entity\Fixation;
use App\Domain\Entity\Group;
use App\Domain\Entity\Revision;

readonly class RevisionBuildService
{
    /**
     * @param FixationService $fixationService
     * @param RevisionService $revisionService
     */
    public function __construct(
        private FixationService $fixationService,
        private RevisionService $revisionService,
    ) {
    }

    /**
     * @param Group $group
     * @param FixableInterface $entity
     *
     * @return array|Revision[]
     */
    public function buildRevisions(Group $group, FixableInterface $entity): array
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
