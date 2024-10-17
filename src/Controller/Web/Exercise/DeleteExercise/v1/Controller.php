<?php

namespace App\Controller\Web\Exercise\DeleteExercise\v1;

use App\Controller\Exception\NotImplementedException;
use App\Domain\Entity\Exercise;
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
     * @param Exercise $exercise
     *
     * @return JsonResponse
     */
    #[Route(path: 'api/v1/exercise/{id}', name: 'exercise_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(#[MapEntity(id: 'id')] Exercise $exercise): JsonResponse
    {
        $this->manager->deleteExercise($exercise);

        return new JsonResponse(['success' => true]);
    }
}
