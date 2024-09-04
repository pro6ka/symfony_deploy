<?php

namespace App\Controller;

use App\Domain\Service\GroupService;
use App\Domain\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WorldController extends AbstractController
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        private readonly UserService $userService,
        private readonly GroupService $groupService
    ) {
    }

    /**
     * @return Response
     */
    public function hello(): Response
    {
        return $this->json([
            $this->userService->findUserByLogin('second user'),
            $this->userService->findUserById(4),
            $this->userService->findUserByEmail('second.user@email.dvl.to'),
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        // $result = $this->userService->create('sixth user');
        $result = $this->groupService->create('first group');

        return $this->json($result);
    }
}
