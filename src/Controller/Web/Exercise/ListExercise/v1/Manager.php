<?php

namespace App\Controller\Web\Exercise\ListExercise\v1;

use App\Controller\Web\Exercise\ListExercise\v1\Output\ListExerciseDTO;
use App\Controller\Web\Exercise\ListExercise\v1\Output\Part\ListExerciseItemDTO;
use App\Controller\Web\Exercise\ListExercise\v1\Output\Part\ListExerciseQuestionDTO;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\Question;
use App\Domain\Model\Exercise\ListExerciseModel;
use App\Domain\Model\PaginationModel;
use App\Domain\Service\ExerciseService;

readonly class Manager
{
    /**
     * @param ExerciseService $exerciseService
     */
    public function __construct(
        private ExerciseService $exerciseService
    ) {
    }

    /**
     * @param int $page
     *
     * @return ListExerciseDTO
     */
    public function getListExercises(int $page): ListExerciseDTO
    {
        $paginator = $this->exerciseService->getList();
        $exerciseList = [];

        /** @var Exercise $exercise */
        foreach ($paginator as $exercise) {
            $exerciseList[] = new ListExerciseItemDTO(
                id: $exercise->getId(),
                title: $exercise->getTitle(),
                content: $exercise->getContent(),
                questions: $exercise->getQuestions()->map(function (Question $question) {
                    return new ListExerciseQuestionDTO(
                        id: $question->getId(),
                        title: $question->getTitle()
                    );
                })->toArray()
            );
        }

        return new ListExerciseDTO(
            exerciseList: $exerciseList,
            pagination: new PaginationModel(
                total: $paginator->count(),
                page: $page,
                pageSize: ListExerciseModel::PAGE_SIZE
            )
        );
    }
}
