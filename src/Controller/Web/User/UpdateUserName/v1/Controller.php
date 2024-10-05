<?php

namespace App\Controller\Web\User\UpdateUserName\v1;

use App\Controller\Web\User\UpdateUserName\v1\Input\UserNameDTO;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
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
    public function __construct(private Manager $manager)
    {
    }

    /**
     * @param UserNameDTO $userNameDTO
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route(path: 'api/v1/user/update-name', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] UserNameDTO $userNameDTO): JsonResponse
    {
        return new JsonResponse($this->manager->updateUserName($userNameDTO));
    }
}
