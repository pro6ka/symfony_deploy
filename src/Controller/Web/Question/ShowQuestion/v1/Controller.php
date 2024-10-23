<?php

namespace App\Controller\Web\Question\ShowQuestion\v1;

use App\Controller\Exception\NotImplementedException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

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
    #[Route(path: 'api/v1/question/{id}', name: 'question_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function __invoke(int $id): JsonResponse
    {
        return new JsonResponse($this->manager->showQuestion($id));
    }
}
