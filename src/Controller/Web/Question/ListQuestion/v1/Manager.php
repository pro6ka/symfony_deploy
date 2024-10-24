<?php

namespace App\Controller\Web\Question\ListQuestion\v1;

use App\Controller\Web\Question\ListQuestion\v1\Output\ListQuestionDTO;
use App\Controller\Web\Question\ListQuestion\v1\Output\Part\ListQuestionItemDTO;
use App\Controller\Web\Question\ListQuestion\v1\Output\Part\ListQuestionsAnswerItemDTO;
use App\Domain\Entity\Answer;
use App\Domain\Entity\Question;
use App\Domain\Model\PaginationModel;
use App\Domain\Model\Question\ListQuestionModel;
use App\Domain\Service\QuestionService;

readonly class Manager
{
    /**
     * @param QuestionService $questionService
     */
    public function __construct(
        private QuestionService $questionService
    ) {
    }

    /**
     * @param int $page
     *
     * @return ListQuestionDTO
     */
    public function listQuestions(int $page): ListQuestionDTO
    {
        $paginator = $this->questionService->getList($page);
        $questionList = [];

        /** @var Question $question */
        foreach ($paginator as $question) {
            $questionList[] = new ListQuestionItemDTO(
                id: $question->getId(),
                title: $question->getTitle(),
                description: $question->getDescription(),
                answers: $question->getAnswers()->map(function (Answer $answer) {
                    return new ListQuestionsAnswerItemDTO(
                        id: $answer->getId(),
                        title: $answer->getTitle(),
                        description: $answer->getDescription()
                    );
                })->toArray()
            );
        }

        return new ListQuestionDTO(
            questionList: $questionList,
            pagination: new PaginationModel(
                total: $paginator->count(),
                page: $page,
                pageSize: ListQuestionModel::PAGE_SIZE
            )
        );
    }
}
