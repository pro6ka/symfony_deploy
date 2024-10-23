<?php

namespace App\Controller\Web\Question\EditQuestion\v1;

use App\Controller\Exception\NotImplementedException;
use App\Controller\Web\Question\EditQuestion\v1\Input\EditQuestionDTO;
use App\Domain\Entity\Question;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Service\Attribute\Required;

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
     * @param EditQuestionDTO $editQuestionDTO
     *
     * @return JsonResponse
     */
    #[Route(
        path: 'api/v1/question/{id}/edit',
        name: 'question_edit',
        requirements: ['id' => '\d+'],
        methods: ['POST']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] Question $question,
        #[MapRequestPayload] EditQuestionDTO $editQuestionDTO
    ): JsonResponse {
        return new JsonResponse($this->manager->editQuestion($editQuestionDTO, $question));
    }
}
