<?php

namespace App\Controller\Web\Workshop\StartWorkshop\v1;

use App\Controller\Web\Workshop\StartWorkshop\v1\Input\StartWorkshopDTO;
use App\Controller\Web\Workshop\StartWorkshop\v1\Output\StartedWorkshopExerciseDTO;
use App\Controller\Web\Workshop\StartWorkshop\v1\Output\StartedWorkshopDTO;
use App\Domain\Entity\Exercise;
use App\Domain\Service\GroupService;
use App\Domain\Service\UserService;
use App\Domain\Service\WorkshopBuildService;
use App\Domain\Service\WorkShopService;
use http\Exception\RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class Manager
{
    public function __construct(
        private WorkShopService $workShopService,
        private WorkshopBuildService $workshopBuildService,
        private UserService $userService,
        private GroupService $groupService
    ) {
    }

    public function startWorkshop(StartWorkshopDTO $startWorkshopDTO, UserInterface $authUser): StartedWorkshopDTO
    {
        if (! $group = $this->groupService->findGroupById($startWorkshopDTO->groupId)) {
            throw new NotFoundHttpException(sprintf('Group id: %d not found', $startWorkshopDTO->groupId));
        }

        if (! $workshop = $this->workShopService->findWorkshopById($startWorkshopDTO->workshopId)) {
            throw new NotFoundHttpException(sprintf('Workshop id: %d not found', $startWorkshopDTO->workshopId));
        }

        $user = $this->userService->findUserByLogin($authUser->getUserIdentifier());

        $startedWorkshop = $this->workshopBuildService->start($workshop, $user, $group);

        return new StartedWorkshopDTO(
            id: $startedWorkshop->getId(),
            title: $startedWorkshop->getTitle(),
            description: $startedWorkshop->getDescription(),
            exercises: $startedWorkshop->getExercises()->map(function (Exercise $exercise) {
                return new StartedWorkshopExerciseDTO(
                    id: $exercise->getId(),
                    title: $exercise->getTitle(),
                    content: $exercise->getContent(),
                    countQuestions: $exercise->getQuestions()->count()
                );
            })->toArray()
        );
    }
}
