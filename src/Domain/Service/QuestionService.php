<?php

namespace App\Domain\Service;

use App\Domain\Entity\Exercise;
use App\Domain\Entity\Question;
use App\Infrastructure\Repository\QuestionRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class QuestionService
{
    public function __construct(
        private QuestionRepository $questionRepository
    ) {
    }

    /**
     * @param string $title
     * @param string $description
     * @param Exercise $exercise
     *
     * @return Question
     */
    public function create(string $title, string $description, Exercise $exercise): Question
    {
        $question = new Question();
        $question->setTitle($title);
        $question->setDescription($description);
        $question->setExercise($exercise);

        $this->questionRepository->create($question);

        return $question;
    }

    /**
     * @param int $questionId
     *
     * @return null|Question
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $questionId): ?Question
    {
        return $this->questionRepository->findById($questionId);
    }
}
