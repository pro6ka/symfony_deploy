<?php

namespace App\Controller\Web\Question\DeleteQuestion\v1;

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
    #[Route(path: 'api/v1/question/{id}', name: 'question_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(): JsonResponse
    {
        throw new NotImplementedException();
    }
}
