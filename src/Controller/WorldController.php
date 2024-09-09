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
     * @param GroupService $groupService
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
        $userResult = $this->userService->create('fifth user');

        return $this->json([
            'user' => $userResult,
        ]);
    }
}
