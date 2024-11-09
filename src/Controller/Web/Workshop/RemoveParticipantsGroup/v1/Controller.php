<?php

namespace App\Controller\Web\Workshop\RemoveParticipantsGroup\v1;

use App\Controller\Web\WorkShop\AddParticipantsGroup\v1\Input\AddParticipantsGroupDTO;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route(
        path: 'api/v1/workshop/remove-participants-group',
        name: 'workshop_remove_participants_group',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] AddParticipantsGroupDTO $participantsGroupDTO): JsonResponse
    {
        return new JsonResponse($this->manager->removeParticipantsGroup($participantsGroupDTO));
    }
}
