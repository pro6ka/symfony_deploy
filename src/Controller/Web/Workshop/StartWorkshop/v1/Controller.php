<?php

namespace App\Controller\Web\Workshop\StartWorkshop\v1;

use App\Controller\Web\Workshop\StartWorkshop\v1\Input\StartWorkshopDTO;
use App\Domain\Exception\GroupIsNotWorkshopParticipantException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[AsController]
readonly class Controller
{
    /**
     * @param Manager $manager
     */
    public function __construct(
        private Manager $manager,
    ) {
    }

    /**
     * @param StartWorkshopDTO $startWorkshopDTO
     * @param $authUser
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route(path: 'api/v1/workshop/start', name: 'workshop_start', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] StartWorkshopDTO $startWorkshopDTO,
        #[CurrentUser] $authUser
    ): JsonResponse {
        return new JsonResponse($this->manager->startWorkshop($startWorkshopDTO, $authUser));
    }
}
