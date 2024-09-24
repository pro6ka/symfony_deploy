<?php

namespace App\Controller;

use App\Domain\Entity\Group;
use App\Domain\Service\FixationService;
use App\Domain\Service\GroupBuildService;
use App\Domain\Service\GroupService;
use App\Domain\Service\RevisionService;
use App\Domain\Service\UserService;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use JetBrains\PhpStorm\NoReturn;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GroupController extends AbstractController
{
    /**
     * @param GroupService $groupService
     * @param GroupBuildService $groupBuildService
     * @param RevisionService $revisionService
     * @param UserService $userService
     * @param FixationService $fixationService
     */
    public function __construct(
        private readonly GroupService $groupService,
        private readonly GroupBuildService $groupBuildService,
        private readonly UserService $userService,
        private readonly FixationService $fixationService,
        private readonly WorkShopService $workShopService
    ) {
    }

    /**
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route('/group/add-participant/{groupId}/{userId}')]
    public function addParticipant(int $groupId, int $userId): JsonResponse
    {
        return $this->json($this->groupBuildService->addParticipant($groupId, $userId));
    }

    /**
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[NoReturn] #[Route('/group/rbowner')]
    public function removeByOwner(): void
    {
        $user = $this->userService->find(2);
        $this->workShopService->listForUser($user);
    }
}
