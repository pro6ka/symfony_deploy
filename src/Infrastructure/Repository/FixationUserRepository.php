<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\FixationUser;

class FixationUserRepository extends AbstractRepository
{
    /**
     * @param FixationUser $fixationUser
     * @param bool $doFlush
     *
     * @return FixationUser
     */
    public function create(FixationUser $fixationUser, bool $doFlush = true): FixationUser
    {
        $this->entityManager->persist($fixationUser);

        if ($doFlush) {
            $this->flush();
        }

        return $fixationUser;
    }
}
