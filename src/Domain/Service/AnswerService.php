<?php

namespace App\Domain\Service;

use App\Domain\Entity\Answer;
use App\Domain\Entity\Question;
use App\Infrastructure\Repository\AnswerRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class AnswerService
{
    /**
     * @param AnswerRepository $answerRepository
     */
    public function __construct(
        private AnswerRepository $answerRepository
    ) {
    }

    /**
     * @param string $title
     * @param string $description
     * @param Question $question
     *
     * @return Answer
     */
    public function create(string $title, string $description, Question $question): Answer
    {
        $answer = new Answer();
        $answer->setTitle($title);
        $answer->setDescription($description);
        $answer->setQuestion($question);
        $this->answerRepository->create($answer);

        return $answer;
    }

    /**
     * @param int $answerId
     *
     * @return null|Answer
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $answerId): ?Answer
    {
        return $this->answerRepository->findById($answerId);
    }
}
