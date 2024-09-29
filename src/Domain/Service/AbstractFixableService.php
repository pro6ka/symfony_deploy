<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\FixableInterface;
use App\Domain\Entity\Fixation;
use App\Domain\Entity\Revision;

abstract readonly class AbstractFixableService
{
    /**
     * @return FixationService
     */
    abstract protected function getFixationService(): FixationService;

    /**
     * @param FixableInterface $entity
     * @param int $userId
     * @param int $groupId
     *
     * @return array|Revision[]
     */
    public function findRevisionsByFixable(FixableInterface $entity, int $userId, int $groupId): array
    {
        return array_reduce(
            $this->getFixationService()->listForUserByEntity($entity, $userId, $groupId),
            function ($carry, Fixation $fixation) {
                /** @var Revision $revision */
                foreach ($fixation->getRevisions() as $revision) {
                    $carry[$revision->getEntityId()][$revision->getColumnName()] = $revision;
                }

                return $carry;
            }
        );
    }
}
