<?php

namespace App\Controller\Web\Exercise\DeleteExercise\v1;

use App\Domain\Entity\Exercise;
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
     * @param Exercise $exercise
     *
     * @return void
     */
    public function deleteExercise(Exercise $exercise): void
    {
        $this->exerciseService->deleteExercise($exercise);
    }
}
