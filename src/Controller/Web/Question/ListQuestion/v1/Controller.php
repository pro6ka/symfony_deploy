<?php

namespace App\Controller\Web\Question\ListQuestion\v1;

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
    #[Route(path: 'api/v1/question/list/{page}', name: 'question_list', methods: ['GET'])]
    public function __invoke(int $page = 1): JsonResponse
    {
        return new JsonResponse($this->manager->listQuestions($page));
    }
}
