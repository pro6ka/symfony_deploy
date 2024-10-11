<?php

namespace App\Controller\Web\User\LeaveGroup\v1;

use App\Controller\Web\User\LeaveGroup\v1\Input\UserLeaveGroupDTO;
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
     * @param UserLeaveGroupDTO $userLeaveGroupDTO
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route(
        path: 'api/v1/user/leave-group',
        name: 'user_leave_group',
        requirements: ['userId' => '\d+', 'groupId' => '\d+'],
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] UserLeaveGroupDTO $userLeaveGroupDTO): JsonResponse
    {
        return new JsonResponse($this->manager->leaveGroup($userLeaveGroupDTO));
    }
}
