<?php

namespace App\Controller\Web\Exercise\EditExercise\v1;

use App\Controller\Web\Exercise\EditExercise\v1\Input\EditExerciseDTO;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    /**
     * @param Manager $manager
     */
    public function __construct(
        private Manager $manager
    ) {
    }

    /**
     * @param EditExerciseDTO $editedExerciseDTO
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route(path: 'api/v1/exercise/edit', name: 'exercise_edit', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] EditExerciseDTO $editedExerciseDTO): JsonResponse
    {
        return new JsonResponse($this->manager->editExercise($editedExerciseDTO));
    }
}
