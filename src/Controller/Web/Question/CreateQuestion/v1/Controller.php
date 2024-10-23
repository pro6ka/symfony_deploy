<?php

namespace App\Controller\Web\Question\CreateQuestion\v1;

use App\Controller\Exception\NotImplementedException;
use App\Controller\Web\Question\CreateQuestion\v1\Input\CreateQuestionDTO;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(
        private Manager $manager
    ) {
    }

    /**
     * @param CreateQuestionDTO $createQuestionDTO
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route(path: 'api/v1/question/create', name: 'question_create', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateQuestionDTO $createQuestionDTO): JsonResponse
    {
        return new JsonResponse($this->manager->createQuestion($createQuestionDTO));
    }
}
