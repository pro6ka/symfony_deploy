<?php

namespace App\Controller\Web\Answer\ShowAnswer\v1;

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
    #[Route(path: 'api/v1/answer/id}', name: 'answer_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        throw new NotImplementedException();
    }
}
