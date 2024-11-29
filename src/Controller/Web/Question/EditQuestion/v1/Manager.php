<?php

namespace App\Controller\Web\Question\EditQuestion\v1;

use App\Controller\Web\Question\EditQuestion\v1\Input\EditQuestionDTO;
use App\Controller\Web\Question\EditQuestion\v1\Output\EditedQuestionDTO;
use App\Domain\Entity\Question;
use App\Domain\Model\Question\EditQuestionModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\QuestionService;

readonly class Manager
{
    /**
     * @param ModelFactory $modelFactory
     * @param QuestionService $questionService
     */
    public function __construct(
        private ModelFactory $modelFactory,
        private QuestionService $questionService
    ) {
    }

    /**
     * @param EditQuestionDTO $editQuestionDTO
     * @param Question $question
     *
     * @return EditedQuestionDTO
     */
    public function editQuestion(EditQuestionDTO $editQuestionDTO, Question $question): EditedQuestionDTO
    {
        $this->questionService->editQuestion($question, $this->modelFactory->makeModel(
            EditQuestionModel::class,
            $editQuestionDTO->title,
            $editQuestionDTO->description
        ));

        return new EditedQuestionDTO(
            id: $question->getId(),
            title: $question->getTitle(),
            description: $question->getDescription(),
            createdAt: $question->getCreatedAt(),
            updatedAt: $question->getUpdatedAt()
        );
    }
}
