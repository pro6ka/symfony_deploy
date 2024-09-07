<?php

namespace App\Controller;

use App\Domain\Entity\Group;
use App\Domain\Service\GroupBuildService;
use App\Domain\Service\GroupService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GroupController extends AbstractController
{
    /**
     * @param GroupService $groupService
     */
    public function __construct(
        private readonly GroupService $groupService,
        private readonly GroupBuildService $groupBuildService
    ) {
    }

    /**
     * @return JsonResponse
     */
    #[Route('/group/create')]
    public function create(): JsonResponse
    {
        $groupResult = $this->groupService->create('zero group');

        return $this->json([$groupResult]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    #[Route('/group/activate/{id}')]
    public function activate(int $id): JsonResponse
    {
        return $this->json($this->groupService->activate($id)->toArray());
    }

    /**
     * @param int $groupId
     * @param int $userId
     *
     * @return JsonResponse
     */
    #[Route('/group/add-participant/{groupId}/{userId}')]
    public function addParticipant(int $groupId, int $userId): JsonResponse
    {
        return $this->json($this->groupBuildService->addParticipant($groupId, $userId));
    }
}
