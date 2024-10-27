<?php

namespace App\Domain\Service;

use App\Domain\Bus\StartWorkshopBusInterface;
use App\Domain\DTO\StartWorkShopDTO;
use App\Domain\Entity\Answer;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\Group;
use App\Domain\Entity\Question;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Exception\GroupIsNotWorkshopParticipantException;
use App\Infrastructure\Repository\WorkShopRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use RuntimeException;

readonly class WorkshopBuildService
{
    /**
     * @param FixationService $fixationService
     * @param RevisionBuildService $revisionBuildService
     * @param FixationUserService $fixationUserService
     * @param FixationGroupService $fixationGroupService
     * @param WorkShopRepository $workShopRepository
     */
    public function __construct(
        private FixationService $fixationService,
        private RevisionBuildService $revisionBuildService,
        private FixationUserService $fixationUserService,
        private FixationGroupService $fixationGroupService,
        private StartWorkshopBusInterface $startWorkshopBus,
        private WorkShopRepository $workShopRepository
    ) {
    }

    /**
     * @param WorkShop $workShop
     * @param User $user
     * @param Group $group
     *
     * @return void
     */
    public function startAsync(WorkShop $workShop, User $user, Group $group): void
    {
        $this->startWorkshopBus->sendStartWorkShopMessage(new StartWorkShopDTO(
            workShopId: $workShop->getId(),
            userId: $user->getId(),
            groupId: $group->getId(),
        ));
    }

    /**
     * @param WorkShop $workShop
     * @param User $user
     * @param Group $group
     *
     * @return WorkShop
     * @throws ORMException|GroupIsNotWorkshopParticipantException
     */
    public function start(WorkShop $workShop, User $user, Group $group): WorkShop
    {
        $questions = [];

        if (! $workShop->getGroupsParticipants()->contains($group)) {
            throw new GroupIsNotWorkshopParticipantException($group->getId(), $workShop->getId());
        }

        /** @var Exercise $exercise */
        foreach ($workShop->getExercises() as $exercise) {
            $exerciseRevisions = $this->revisionBuildService
                ->buildRevisions($group, $exercise);
            foreach ($exerciseRevisions as $exerciseRevision) {
                $this->fixationService->build(
                    $exercise,
                    $this->fixationUserService->build($user),
                    $exerciseRevision,
                    $this->fixationGroupService->build($group),
                );
            }
            $questions = array_merge($questions, $exercise->getQuestions()->toArray());
        }


        $answers = [];

        /** @var Question $question */
        foreach ($questions as $question) {
            $questionRevisions = $this->revisionBuildService->buildRevisions($group, $question);
            foreach ($questionRevisions as $questionRevision) {
                $this->fixationService->build(
                    $question,
                    $this->fixationUserService->build($user),
                    $questionRevision,
                    $this->fixationGroupService->build($group)
                );
            }
            $answers = array_merge($answers, $question->getAnswers()->toArray());
        }

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            $answerRevisions = $this->revisionBuildService->buildRevisions($group, $answer);
            foreach ($answerRevisions as $answerRevision) {
                $this->fixationService->build(
                    $answer,
                    $this->fixationUserService->build($user),
                    $answerRevision,
                    $this->fixationGroupService->build($group)
                );
            }
        }

        $workshopRevisions = $this->revisionBuildService->buildRevisions($group, $workShop);
        foreach ($workshopRevisions as $workshopRevision) {
            $this->fixationService->create(
                $workShop,
                $this->fixationUserService->build($user),
                $workshopRevision,
                $this->fixationGroupService->build($group)
            );
        }

        $this->workShopRepository->refresh($workShop);

        return $workShop;
    }
}
