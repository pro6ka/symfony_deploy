<?php

namespace App\Controller\Web\Exercise\CreateExercise\v1;

use App\Controller\Exception\NotImplementedException;
use App\Controller\Web\Exercise\CreateExercise\v1\Input\CreateExerciseDTO;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param CreateExerciseDTO $createExerciseDTO
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route(path: 'api/v1/exercise/create', name: 'exercise_create', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateExerciseDTO $createExerciseDTO): JsonResponse
    {
        return new JsonResponse($this->manager->createExercise($createExerciseDTO), Response::HTTP_CREATED);
    }
}
