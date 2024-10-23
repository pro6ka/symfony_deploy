<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Question;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;

class QuestionRepository extends AbstractRepository
{
    /**
     * @param Question $question
     *
     * @return int
     */
    public function create(Question $question): int
    {
        return $this->store($question);
    }

    /**
     * @param int $id
     *
     * @return null|Question
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $id): ?Question
    {
        return $this->entityManager->getRepository(Question::class)
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
        $queryBuilder->select('q')
            ->from(Question::class, 'q')
            ->setFirstResult($firstResult)
            ->setMaxResults($pageSize)
            ;

        return new Paginator($queryBuilder->getQuery());
    }
}
