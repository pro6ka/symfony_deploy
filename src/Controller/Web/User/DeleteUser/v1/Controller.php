<?php

namespace App\Controller\Web\User\DeleteUser\v1;

use App\Domain\Entity\User;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    /**
     * @param Manager $manager
     */
    public function __construct(private Manager $manager)
    {
    }

    /**
     * @param User $user
     *
     * @return Response
     */
    #[Route(path: 'api/v1/user/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(#[MapEntity(id: 'id')] User $user): Response
    {
        $this->manager->deleteUser($user);

        return new JsonResponse(['success' => true]);
    }
}
