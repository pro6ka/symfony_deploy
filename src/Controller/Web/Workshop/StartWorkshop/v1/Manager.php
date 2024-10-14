<?php

namespace App\Controller\Web\Workshop\StartWorkshop\v1;

use App\Controller\Web\Workshop\StartWorkshop\v1\Input\StartWorkshopDTO;
use App\Controller\Web\Workshop\StartWorkshop\v1\Output\Part\StartedWorkshopExerciseDTO;
use App\Controller\Web\Workshop\StartWorkshop\v1\Output\StartedWorkshopDTO;
use App\Domain\Entity\Exercise;
use App\Domain\Exception\GroupIsNotWorkshopParticipantException;
use App\Domain\Service\GroupService;
use App\Domain\Service\UserService;
use App\Domain\Service\WorkshopBuildService;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class Manager
{
    /**
     * @param WorkShopService $workShopService
     * @param WorkshopBuildService $workshopBuildService
     * @param UserService $userService
     * @param GroupService $groupService
     */
    public function __construct(
        private WorkShopService $workShopService,
        private WorkshopBuildService $workshopBuildService,
        private UserService $userService,
        private GroupService $groupService
    ) {
    }

    /**
     * @param StartWorkshopDTO $startWorkshopDTO
     * @param UserInterface $authUser
     *
     * @return StartedWorkshopDTO
     * @throws GroupIsNotWorkshopParticipantException
     * @throws ORMException
     * @throws OptimisticLockException
     */
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
