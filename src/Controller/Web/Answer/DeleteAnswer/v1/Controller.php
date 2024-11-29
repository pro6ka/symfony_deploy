<?php

namespace App\Controller\Web\Answer\DeleteAnswer\v1;

use App\Controller\Exception\NotImplementedException;
use App\Domain\Entity\Answer;
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
     * @param Answer $answer
     *
     * @return JsonResponse
     */
    #[Route(path: 'api/v1/answer/{id}', name: 'answer_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(#[MapEntity(id: 'id')] Answer $answer): JsonResponse
    {
        $this->manager->deleteAnswer($answer);

        return new JsonResponse(['success' => true]);
    }
}
