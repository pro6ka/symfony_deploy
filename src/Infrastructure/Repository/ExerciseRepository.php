<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Exercise;
use App\Domain\Entity\WorkShop;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class ExerciseRepository extends AbstractRepository
{
    /**
     * @param Exercise $exercise
     *
     * @return int
     */
    public function create(Exercise $exercise): int
    {
        return $this->store($exercise);
    }

    /**
     * @param int $id
     *
     * @return null|Exercise
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $id): ?Exercise
    {
        return $this->entityManager->getRepository(Exercise::class)
            ->find($id);
    }
}
