<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Answer;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\Group;
use App\Domain\Entity\Question;
use App\Domain\Entity\WorkShop;
use App\Domain\Model\Answer\AnswerModel;
use App\Domain\Model\Exercise\ExerciseModel;
use App\Domain\Model\Group\GroupModel;
use App\Domain\Model\Question\QuestionModel;
use App\Domain\Model\User\WorkShopAuthorModel;
use App\Domain\Model\Workshop\WorkShopModel;

readonly class WorkShopModelFactory
{
    /**
     * @param WorkShop $workShop
     *
     * @return WorkShopModel
     */
    public function fromEntity(WorkShop $workShop): WorkShopModel
    {
        return new WorkShopModel(
            id: $workShop->getId(),
            title: $workShop->getTitle(),
            description: $workShop->getDescription(),
            createdAt: $workShop->getCreatedAt(),
            updatedAt: $workShop->getUpdatedAt(),
            author: new WorkShopAuthorModel(
                id: $workShop->getAuthor()->getId(),
                firstName: $workShop->getAuthor()->getFirstName(),
                lastName: $workShop->getAuthor()->getLastName(),
                middleName: $workShop->getAuthor()->getMiddleName()
            ),
            exercises: array_map(
                fn (Exercise $exercise) => new ExerciseModel(
                    id: $exercise->getId(),
                    title: $exercise->getTitle(),
                    content: $exercise->getContent(),
                    questions: array_map(
                        fn (Question $question) => new QuestionModel(
                            id: $question->getId(),
                            title: $question->getTitle(),
                            description: $question->getDescription(),
                            answers: array_map(
                                fn (Answer $answer) => new AnswerModel(
                                    id: $answer->getId(),
                                    title: $answer->getTitle(),
                                    description: $answer->getDescription()
                                ),
                                $question->getAnswers()->toArray()
                            )
                        ),
                        $exercise->getQuestions()->toArray()
                    )
                ),
                $workShop->getExercises()->toArray()
            ),
            groupParticipants: array_map(
                fn (Group $group) => new GroupModel(
                    id: $group->getId(),
                    name: $group->getName(),
                    isActive: $group->getIsActive(),
                    workingFrom: $group->getWorkingFrom(),
                    workingTo: $group->getWorkingTo(),
                    createdAt: $group->getCreatedAt(),
                    updatedAt: $group->getUpdatedAt(),
                    participants: $group->getParticipants()->toArray()
                ),
                $workShop->getGroupsParticipants()->toArray()
            )
        );
    }
}
