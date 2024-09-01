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
        return $this->json(['hello' => 'world']);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        $user = $this->userService->create('third user');

        return $this->json($user);
    }
}
