<?php

namespace App\Controller;

use App\Domain\Entity\Group;
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
        private readonly GroupService $groupService
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
     * @param int $groupId
     *
     * @return JsonResponse
     */
    #[Route('/group/activate/{id}')]
    public function activate(int $id): JsonResponse
    {
        return $this->json($this->groupService->activate($id)->toArray());
    }
}
