<?php

namespace App\Controller\Web\Exercise\ListExercise\v1;

use App\Controller\Exception\NotImplementedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
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
     * @param int $page
     *
     * @return JsonResponse
     */
    #[Route(
        path: 'api/v1/exercise/list/{page}',
        name: 'exercise_list',
        requirements: ['page' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(int $page = 1): JsonResponse
    {
        return new JsonResponse(['exercises' => $this->manager->getListExercises($page)]);
    }
}
