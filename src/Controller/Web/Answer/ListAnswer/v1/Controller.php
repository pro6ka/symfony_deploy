<?php

namespace App\Controller\Web\Answer\ListAnswer\v1;

use App\Controller\Exception\NotImplementedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
readonly class Controller
{
    /**
     * @return JsonResponse
     * @throws NotImplementedException
     */
    #[Route(path: 'api/v1/answer/', name: 'answer_list', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        throw new NotImplementedException();
    }
}
