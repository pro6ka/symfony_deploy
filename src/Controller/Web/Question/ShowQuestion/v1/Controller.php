<?php

namespace App\Controller\Web\Question\ShowQuestion\v1;

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
    #[Route(path: 'api/v1/question/id}', name: 'question_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        throw new NotImplementedException();
    }
}
