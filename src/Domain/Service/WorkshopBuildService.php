<?php

namespace App\Domain\Service;

use App\Domain\Entity\Answer;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\Group;
use App\Domain\Entity\Question;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use Doctrine\ORM\NonUniqueResultException;

readonly class WorkshopBuildService
{
    /**
     * @param FixationService $fixationService
     * @param RevisionBuildService $revisionBuildService
     */
    public function __construct(
        private FixationService $fixationService,
        private RevisionBuildService $revisionBuildService
    ) {
    }

    /**
     * @param WorkShop $workShop
     * @param User $user
     * @param Group $group
     *
     * @todo Refactor this. Move foreach`s to separate service
     *
     * @return array
     * @throws NonUniqueResultException
     */
    public function start(WorkShop $workShop, User $user, Group $group): array
    {
        $questions = [];

        /** @var Exercise $exercise */
        foreach ($workShop->getExercises() as $exercise) {
            $exerciseRevision = $this->revisionBuildService->buildRevision($group, $exercise);
            $this->fixationService->build($exercise, $user, $exerciseRevision, $group);
            $questions = array_merge($questions, $exercise->getQuestions()->toArray());
        }

        $answers = [];

        /** @var Question $question */
        foreach ($questions as $question) {
            $questionRevision = $this->revisionBuildService->buildRevision($group, $question);
            $this->fixationService->build($question, $user, $questionRevision, $group);
            $answers = array_merge($answers, $question->getAnswers()->toArray());
        }

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            $answerRevision = $this->revisionBuildService->buildRevision($group, $answer);
            $this->fixationService->build($answer, $user, $answerRevision, $group);
        }

        $workshopRevision = $this->revisionBuildService->buildRevision($group, $workShop);
        $workshopFixation = $this->fixationService->build($workShop, $user, $workshopRevision, $group);
//        $this->fixationService->

        return $workShop->toArray();
    }
}
