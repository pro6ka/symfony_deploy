<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Exercise;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;

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

    /**
     * @param int $pageSize
     * @param int $firstResult
     *
     * @return Paginator
     */
    public function getList(int $pageSize, int $firstResult): Paginator
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('e')
            ->from(Exercise::class, 'e')
            ->setFirstResult($firstResult)
            ->setMaxResults($pageSize)
            ;

        return new Paginator($queryBuilder->getQuery());
    }

    /**
     * @param Exercise $exercise
     *
     * @return void
     */
    public function removeExercise(Exercise $exercise): void
    {
        $this->remove($exercise);
    }
}
