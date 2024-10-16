<?php

namespace App\Controller\Web\Exercise\ShowExercise\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use \Doctrine\ORM\Exception\ORMException;
use \Doctrine\ORM\OptimisticLockException;

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
     * @param int $id
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route(path: 'api/v1/exercise/{id}', name: 'exercise_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function __invoke(int $id): JsonResponse
    {
        return new JsonResponse($this->manager->showExercise($id));
    }
}
