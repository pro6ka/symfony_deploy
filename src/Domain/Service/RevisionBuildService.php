<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\FixableInterface;
use App\Domain\Entity\Group;
use App\Domain\Entity\Revision;
use Doctrine\ORM\NonUniqueResultException;

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
     * @return Revision
     * @throws NonUniqueResultException
     */
    public function buildRevision(Group $group, FixableInterface $entity): Revision
    {
        if ($groupFixation = $this->fixationService->hasGroupFixation($group, $entity)) {
            return $groupFixation->getRevision();
        }

        return $this->revisionService->findLastForEntity($entity);
    }
}
