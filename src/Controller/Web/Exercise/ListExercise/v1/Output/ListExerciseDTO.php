<?php

namespace App\Controller\Web\Exercise\ListExercise\v1\Output;

use App\Controller\Web\Exercise\ListExercise\v1\Output\Part\ListExerciseItemDTO;
use App\Domain\Model\PaginationModel;

readonly class ListExerciseDTO
{
    /**
     * @param array|ListExerciseItemDTO[] $exerciseList
     * @param PaginationModel $pagination
     */
    public function __construct(
        public array $exerciseList,
        public PaginationModel $pagination
    ) {
    }
}
