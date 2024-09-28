<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\FixationGroup;

class FixationGroupRepository extends AbstractRepository
{
    /**
     * @param FixationGroup $fixationGroup
     * @param bool $doFlush
     *
     * @return FixationGroup
     */
    public function create(FixationGroup $fixationGroup, bool $doFlush = true): FixationGroup
    {
        $this->entityManager->persist($fixationGroup);

        if ($doFlush) {
            $this->flush();
        }

        return $fixationGroup;
    }
}
