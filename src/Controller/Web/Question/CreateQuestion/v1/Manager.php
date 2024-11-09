<?php

namespace App\Controller\Web\Question\CreateQuestion\v1;

use App\Controller\Web\Question\CreateQuestion\v1\Input\CreateQuestionDTO;
use App\Controller\Web\Question\CreateQuestion\v1\Output\CreatedQuestionDTO;
use App\Controller\Web\Question\CreateQuestion\v1\Output\Part\QuestionsAnswerDTO;
use App\Controller\Web\Question\CreateQuestion\v1\Output\Part\QuestionsExerciseDTO;
use App\Domain\Entity\Answer;
use App\Domain\Model\Question\CreateQuestionModel;
use App\Domain\Service\ExerciseService;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\QuestionService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class Manager
{
    /**
     * @param ModelFactory $modelFactory
     * @param ExerciseService $exerciseService
     * @param QuestionService $questionService
     */
    public function __construct(
        private ModelFactory $modelFactory,
        private ExerciseService $exerciseService,
        private QuestionService $questionService
    ) {
    }

    /**
     * @param CreateQuestionDTO $createQuestionDTO
     *
     * @return CreatedQuestionDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createQuestion(CreateQuestionDTO $createQuestionDTO): CreatedQuestionDTO
    {
        $exercise = $this->exerciseService->findById($createQuestionDTO->exerciseId);

        if (! $exercise) {
            throw new BadRequestHttpException(sprintf('Exercise id: %d not found', $createQuestionDTO->exerciseId));
        }

        $question = $this->questionService->create($this->modelFactory->makeModel(
            CreateQuestionModel::class,
            $createQuestionDTO->title,
            $createQuestionDTO->description,
            $exercise
        ));

        return new CreatedQuestionDTO(
            id: $question->getId(),
            title: $question->getTitle(),
            description: $question->getDescription(),
            createdAt: $question->getCreatedAt(),
            updatedAt: $question->getUpdatedAt(),
            exercise: new QuestionsExerciseDTO(
                id: $question->getExercise()->getId(),
                title: $question->getExercise()->getTitle(),
                content: $question->getExercise()->getContent(),
            ),
            answers: $question->getAnswers()->map(function (Answer $answer) {
                return new QuestionsAnswerDTO(
                    id: $answer->getId(),
                    title: $answer->getTitle(),
                    description: $answer->getDescription()
                );
            })->toArray()
        );
    }
}
