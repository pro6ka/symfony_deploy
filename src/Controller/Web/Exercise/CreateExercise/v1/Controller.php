<?php

namespace App\Controller\Web\Exercise\CreateExercise\v1;

use App\Controller\Exception\NotImplementedException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
readonly class Controller
{
    /**
     * @return JsonResponse
     * @throws Exception
     */
    #[Route(path: 'api/v1/exercise/create', name: 'exercise_create', methods: ['POST'])]
    public function __invoke(): JsonResponse
    {
        throw new NotImplementedException();
    }
}
