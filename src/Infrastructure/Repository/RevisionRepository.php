<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Revision;
use App\Infrastructure\Repository\AbstractRepository;

class RevisionRepository extends AbstractRepository
{
    /**
     * @param Revision $revision
     *
     * @return int
     */
    public function create(Revision $revision): int
    {
        return $this->store($revision);
    }
}
