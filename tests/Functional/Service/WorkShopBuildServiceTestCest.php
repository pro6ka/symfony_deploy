<?php

namespace App\Tests\Functional\Service;

use App\Domain\Entity\Answer;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\Group;
use App\Domain\Entity\Question;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Exception\GroupIsNotWorkshopParticipantException;
use App\Domain\Exception\WorkShopIsNotReadToStartException;
use App\Domain\Model\Exercise\ExerciseModel;
use App\Domain\Model\Group\GroupModel;
use App\Domain\Model\User\UserModel;
use App\Domain\Model\User\WorkShopAuthorModel;
use App\Domain\Model\Workshop\WorkShopModel;
use App\Domain\Service\WorkshopBuildService;
use App\Tests\Support\FunctionalTester;
use Codeception\Example;
use Codeception\Exception\InjectionException;
use DateTime;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use Support\Helper\Factories;

class WorkShopBuildServiceTestCest
{
    public function _before(FunctionalTester $I): void
    {}

    /**
     * @param FunctionalTester $I
     *
     * @return void
     * @throws GroupIsNotWorkshopParticipantException
     * @throws InjectionException
     * @throws ORMException
     * @throws WorkShopIsNotReadToStartException
     */
    public function startWorkShopTest(FunctionalTester $I): void
    {
        $user = $I->have(User::class, ['login' => Factories::ROLE_USER_LOGIN]);
        /** @var Group $group */
        $group = $I->have(Group::class, ['id' => $I->getGroupData()['id']]);
        /** @var WorkShop $workShop */
        $user->addGroup($group);

        /** @var Answer $answer */
        $answer = $I->make(Answer::class, []);
        /** @var Question $question */
        $question = $I->make(Question::class, []);
        $question->addAnswer($answer);
        /** @var Exercise $exercise */
        $exercise = $I->make(Exercise::class, []);
        $exercise->addQuestion($question);
        $workShop = $I->have(WorkShop::class, ['id' => $I->getWorkShopData()['id']]);
        $workShop->setAuthor($I->make(User::class, []));
        $workShop->addGroupParticipant($group);
        $workShop->addExercise($exercise);

        /** @var WorkShopBuildService $workShopBuildService */
        $workShopBuildService = $I->grabService(WorkshopBuildService::class);

        $result = $workShopBuildService->start(
            $this->getWorkShopModel($workShop),
            $user,
            $this->groupModel($group)
        );

        $I->assertInstanceOf(WorkShop::class, $result);
    }

    /**
     * @param FunctionalTester $I
     *
     * @return void
     * @throws InjectionException
     * @throws Exception
     * @throws ORMException
     */
    public function startWorkShopWithoutExercisesTest(FunctionalTester $I): void
    {
        $user = $I->have(User::class, ['login' => Factories::ROLE_USER_LOGIN]);
        /** @var Group $group */
        $group = $I->have(Group::class, ['id' => $I->getGroupData()['id']]);
        /** @var WorkShop $workShop */
        $user->addGroup($group);
        $workShop = $I->have(WorkShop::class, ['id' => $I->getWorkShopData()['id']]);
        $workShop->setAuthor($I->make(User::class, []));
        $workShop->addGroupParticipant($group);

        /** @var WorkshopBuildService $workShopBuildService */
        $workShopBuildService = $I->grabService(WorkshopBuildService::class);

        $I->expectThrowable(
            WorkShopIsNotReadToStartException::class,
            fn () => $workShopBuildService->start(
                $this->getWorkShopModel($workShop),
                $user,
                $this->groupModel($group)
            )
        );
    }

    /**
     * @param FunctionalTester $I
     *
     * @return void
     * @throws InjectionException
     * @throws Exception
     */
    public function startWorkShopNotAuthorizedTest(FunctionalTester $I): void
    {
        /** @var WorkshopBuildService $workShopBuildService */
        $workShopBuildService = $I->grabService(WorkshopBuildService::class);
        /** @var WorkShop $workShop */
        $workShop = $I->make(WorkShop::class, []);
        $user = $I->make(User::class, []);
        $workShop->setAuthor($user);
        $workShopModel = $this->getWorkShopModel($workShop);

        $I->expectThrowable(
            GroupIsNotWorkshopParticipantException::class,
            fn () => $workShopBuildService->start(
                $workShopModel,
                $user,
                $this->groupModel($I->make(Group::class, []))
            )
        );
    }

    /**
     * @param Group $group
     *
     * @return GroupModel
     */
    private function groupModel(Group $group): GroupModel
    {
        return new GroupModel(
            id: $group->getId(),
            name: $group->getName(),
            isActive: $group->getIsActive(),
            workingFrom: $group->getWorkingFrom(),
            workingTo: $group->getWorkingTo(),
            createdAt: (new DateTime())->modify('-10 days'),
            updatedAt: (new DateTime())->modify('-1 day'),
            participants: $group->getParticipants()->toArray(),
        );
    }

    /**
     * @param WorkShop $workShop
     *
     * @return WorkShopModel
     * @throws Exception
     */
    private function getWorkShopModel(WorkShop $workShop): WorkShopModel
    {
        return new WorkShopModel(
            id: $workShop->getId(),
            title: $workShop->getTitle(),
            description: $workShop->getDescription(),
            createdAt: $workShop->getCreatedAt(),
            updatedAt: $workShop->getUpdatedAt(),
            author: $this->workShopAuthorModel($workShop->getAuthor()),
//            exercises: $workShop->getExercises()->toArray(),
            exercises: array_map(
                fn (Exercise $exercise) => $this->exerciseModel($exercise),
                $workShop->getExercises()->toArray()
            ),
            groupParticipants: array_map(
                fn (Group $group) => $this->groupModel($group),
                $workShop->getGroupsParticipants()->toArray()
            )
        );
    }

    /**
     * @param Exercise $exercise
     *
     * @return ExerciseModel
     */
    private function exerciseModel(Exercise $exercise): ExerciseModel
    {
        return new ExerciseModel(
            id: $exercise->getId(),
            title: $exercise->getTitle(),
            content: $exercise->getContent(),
            questions: []
        );
    }


    /**
     * @param User $user
     *
     * @return WorkShopAuthorModel
     */
    private function workShopAuthorModel(User $user): WorkShopAuthorModel
    {
        return new WorkShopAuthorModel(
            id: $user->getId(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            middleName: $user->getMiddleName(),
        );
    }
}
