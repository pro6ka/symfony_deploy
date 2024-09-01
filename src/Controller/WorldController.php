<?php

namespace App\Controller;

use App\Domain\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WorldController extends AbstractController
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        private readonly UserService $userService
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
        $user = $this->userService->create('fourth user');

        return $this->json($user);
    }
}
