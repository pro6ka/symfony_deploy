<?php

namespace App\Domain\Service;

use App\Domain\Entity\Answer;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\Group;
use App\Domain\Entity\Question;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
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
        private WorkShopRepository $workShopRepository
    ) {
    }

    /**
     * @param WorkShop $workShop
     * @param User $user
     * @param Group $group
     *
     * @return array
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws RuntimeException
     */
    public function start(WorkShop $workShop, User $user, Group $group): array
    {
        $questions = [];

        /** @var Exercise $exercise */
        foreach ($workShop->getExercises() as $exercise) {
            $exerciseRevision = $this->revisionBuildService
                ->buildRevision($group, $exercise);
            $fixation = $this->fixationService->build(
                $exercise,
                $this->fixationUserService->build($user),
                $exerciseRevision,
                $this->fixationGroupService->build($group),
            );
            $questions = array_merge($questions, $exercise->getQuestions()->toArray());
        }


        $answers = [];

        /** @var Question $question */
        foreach ($questions as $question) {
            $questionRevision = $this->revisionBuildService->buildRevision($group, $question);
            $this->fixationService->build(
                $question,
                $this->fixationUserService->build($user),
                $questionRevision,
                $this->fixationGroupService->build($group)
            );
            $answers = array_merge($answers, $question->getAnswers()->toArray());
        }

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            $answerRevision = $this->revisionBuildService->buildRevision($group, $answer);
            $this->fixationService->build(
                $answer,
                $this->fixationUserService->build($user),
                $answerRevision,
                $this->fixationGroupService->build($group)
            );
        }

        $workshopRevision = $this->revisionBuildService->buildRevision($group, $workShop);
        $this->fixationService->create(
            $workShop,
            $this->fixationUserService->build($user),
            $workshopRevision,
            $this->fixationGroupService->build($group)
        );
        $this->workShopRepository->refresh($workShop);

        return $workShop->toArray();
    }
}
