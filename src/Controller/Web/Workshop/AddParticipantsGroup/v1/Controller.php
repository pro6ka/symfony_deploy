<?php

namespace App\Controller\Web\Workshop\AddParticipantsGroup\v1;

use App\Controller\Web\Workshop\AddParticipantsGroup\v1\Input\AddParticipantsGroupDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
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
     * @param AddParticipantsGroupDTO $participantsGroupDTO
     *
     * @return JsonResponse
     */
    #[Route(
        path: 'api/v1/workshop/add-participants-group',
        name: 'workshop_add_participants_group',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] AddParticipantsGroupDTO $participantsGroupDTO): JsonResponse
    {
        return new JsonResponse($this->manager->addParticipantsGroup($participantsGroupDTO));
    }
}
