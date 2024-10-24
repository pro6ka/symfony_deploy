<?php

namespace App\Controller\Web\Question\DeleteQuestion\v1;

use App\Controller\Exception\NotImplementedException;
use App\Domain\Entity\Question;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
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
     * @param Question $question
     *
     * @return JsonResponse
     */
    #[Route(path: 'api/v1/question/{id}', name: 'question_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(#[MapEntity(id: 'id')] Question $question): JsonResponse
    {
        $this->manager->deleteQuestion($question);

        return new JsonResponse(['success' => true]);
    }
}
