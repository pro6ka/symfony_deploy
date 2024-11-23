<?php

namespace App\Domain\Service;

use App\Domain\Bus\StartWorkshopBusInterface;
use App\Domain\DTO\WorkShop\FlushWorkShopCacheDTO;
use App\Domain\DTO\WorkShop\StartWorkShopDTO;
use App\Domain\Entity\Answer;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\Question;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Exception\GroupIsNotWorkshopParticipantException;
use App\Domain\Exception\WorkShopIsNotReadToStartException;
use App\Domain\Model\Exercise\ExerciseModel;
use App\Domain\Model\Group\GroupModel;
use App\Domain\Model\Question\QuestionModel;
use App\Domain\Model\Workshop\WorkShopModel;
use App\Infrastructure\Repository\WorkShopRepository;
use Doctrine\ORM\Exception\ORMException;

readonly class WorkshopBuildService
{
    /**
     * @param FixationService $fixationService
     * @param RevisionBuildService $revisionBuildService
     * @param FixationUserService $fixationUserService
     * @param FixationGroupService $fixationGroupService
     * @param StartWorkshopBusInterface $startWorkshopBus
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
     * @param WorkShopModel $workShop
     * @param User $user
     * @param GroupModel $group
     *
     * @return void
     */
    public function startAsync(WorkShopModel $workShop, User $user, GroupModel $group): void
    {
        $this->startWorkshopBus->sendStartWorkShopMessage(new StartWorkShopDTO(
            workShopId: $workShop->id,
            userId: $user->getId(),
            groupId: $group->id,
        ));
    }

    /**
     * @param int $userId
     * @param int $workShopId
     *
     * @return void
     */
    public function flushCacheAsync(int $userId, int $workShopId): void
    {
        $this->startWorkshopBus->sendFlushWorkShopCacheMessage(new FlushWorkShopCacheDTO(
            userId: $userId,
            workShopId: $workShopId,
        ));
    }

    /**
     * @param WorkShopModel $workShop
     * @param User $user
     * @param GroupModel $group
     *
     * @return WorkShop
     * @throws ORMException
     * @throws GroupIsNotWorkshopParticipantException
     * @throws WorkShopIsNotReadToStartException
     */
    public function start(
        WorkShopModel $workShop,
        User $user,
        GroupModel $group
    ): WorkShop {
        if (! $workShop->isGroupParticipant($group)) {
            throw new GroupIsNotWorkshopParticipantException($group->id, $workShop->getId());
        }

        if (! $this->isWorkShopReadyToStart($workShop)) {
            throw new WorkShopIsNotReadToStartException($workShop->id);
        }

        $questions = [];

        /** @var Exercise $exercise */
        foreach ($workShop->exercises as $exercise) {
            $exerciseRevisions = $this->revisionBuildService
                ->buildRevisions($group, $exercise);
            foreach ($exerciseRevisions as $exerciseRevision) {
                $this->fixationService->build(
                    entity: $exercise,
                    fixationUser: $this->fixationUserService->build($user),
                    revision: $exerciseRevision,
                    fixationGroup: $this->fixationGroupService->build($group),
                );
            }
            $questions = array_merge($questions, $exercise->questions);
        }

        $answers = [];

        /** @var Question $question */
        foreach ($exercise->questions as $question) {
            $questionRevisions = $this->revisionBuildService->buildRevisions($group, $question);
            foreach ($questionRevisions as $questionRevision) {
                $this->fixationService->build(
                    entity: $question,
                    fixationUser: $this->fixationUserService->build($user),
                    revision: $questionRevision,
                    fixationGroup: $this->fixationGroupService->build($group)
                );
            }
            $answers = array_merge($answers, $question->answers);
        }

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            $answerRevisions = $this->revisionBuildService->buildRevisions($group, $answer);
            foreach ($answerRevisions as $answerRevision) {
                $this->fixationService->build(
                    entity: $answer,
                    fixationUser: $this->fixationUserService->build($user),
                    revision: $answerRevision,
                    fixationGroup: $this->fixationGroupService->build($group)
                );
            }
        }

        $workshopRevisions = $this->revisionBuildService
            ->buildRevisions($group, $workShop);
        $workShopEntity = $this->workShopRepository->findById($workShop->id);

        foreach ($workshopRevisions as $workshopRevision) {
            $this->fixationService->create(
                $workShopEntity,
                $this->fixationUserService->build($user),
                $workshopRevision,
                $this->fixationGroupService->build($group)
            );
        }

        $this->workShopRepository->refresh($workShopEntity);
        $this->flushCacheAsync($user->getId(), $workShopEntity->getId());

        return $workShopEntity;
    }

    /**
     * @param WorkShopModel $workshop
     *
     * @return bool
     */
    public function isWorkShopReadyToStart(WorkShopModel $workShop): bool
    {
        return count(array_map(
            function (ExerciseModel $exercise) {
                return array_map(
                    fn (QuestionModel $question) => count($question->answers),
                    $exercise->questions
                );
            },
            $workShop->exercises
        )) > 0;
    }
}
