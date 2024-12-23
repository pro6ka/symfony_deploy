<?php

namespace App\Controller\Web\Group\AddParticipantGroup\v1;

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
     * @param int $groupId
     * @param int $userId
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route(
        path: 'api/v1/group/{groupId}/add-participant/{userId}',
        name: 'group_add_participant',
        requirements: ['groupId' => '\d+', 'userId' => '\d+'],
        methods: ['POST']
    )]
    public function __invoke(int $groupId, int $userId): JsonResponse
    {
        return new JsonResponse($this->manager->addParticipant($groupId, $userId));
    }
}
