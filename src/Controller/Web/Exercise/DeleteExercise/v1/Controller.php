<?php

namespace App\Controller\Web\Exercise\DeleteExercise\v1;

use App\Controller\Exception\NotImplementedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    /**
     * @return JsonResponse
     * @throws NotImplementedException
     */
    #[Route(path: 'api/v1/exercise/{id}', name: 'exercise_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(): JsonResponse
    {
        throw new NotImplementedException();
    }
}
