<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Question;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

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
}
