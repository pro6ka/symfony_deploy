<?php

namespace App\Controller\Web\Group\UpdateName\v1;

use App\Controller\Web\Group\UpdateName\v1\Input\UpdateGroupNameDTO;
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
    public function __construct(
        private Manager $manager
    ) {
    }

    /**
     * @param int $id
     * @param UpdateGroupNameDTO $updateGroupNameDTO
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route(path: 'api/v1/group/{id}/update-name', name: 'group_update_name', methods: ['POST'])]
    public function __invoke(int $id, #[MapRequestPayload] UpdateGroupNameDTO $updateGroupNameDTO): JsonResponse
    {
        $this->manager->updateName($id, $updateGroupNameDTO);

        return new JsonResponse(['success' => true]);
    }
}
