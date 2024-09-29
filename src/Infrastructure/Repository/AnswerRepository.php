<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Answer;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class AnswerRepository extends AbstractRepository
{
    /**
     * @param Answer $answer
     *
     * @return int
     */
    public function create(Answer $answer): int
    {
        return $this->store($answer);
    }

    /**
     * @param int $id
     *
     * @return null|Answer
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $id): ?Answer
    {
        return $this->entityManager->getRepository(Answer::class)
            ->find($id);
    }
}
