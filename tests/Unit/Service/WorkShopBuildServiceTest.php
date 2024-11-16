<?php

namespace Tests\Unit\Service;

use App\Domain\Bus\StartWorkshopBusInterface;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Exception\GroupIsNotWorkshopParticipantException;
use App\Domain\Model\Answer\AnswerModel;
use App\Domain\Model\Exercise\ExerciseModel;
use App\Domain\Model\Group\GroupModel;
use App\Domain\Model\Question\QuestionModel;
use App\Domain\Model\User\WorkShopAuthorModel;
use App\Domain\Model\Workshop\WorkShopModel;
use App\Infrastructure\Repository\WorkShopRepository;
use App\Domain\Service\FixationGroupService;
use App\Domain\Service\FixationService;
use App\Domain\Service\FixationUserService;
use App\Domain\Service\RevisionBuildService;
use App\Domain\Service\WorkshopBuildService;
use App\Tests\Support\UnitTester;
use Codeception\Test\Unit;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use Generator;
use Mockery;
use Mockery\Exception\RuntimeException;
use ReflectionException;

class WorkShopBuildServiceTest extends Unit
{
    protected UnitTester $tester;

    /**
     * @throws ORMException
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws Exception
     */
    public function testStartWorkshopWithoutAnswersException(): void
    {
        $user = $this->prepareUser();
        $worksShopModel = $this->prepareWorkShopModel(false);
        $workShopBuildService = $this->prepareWorkShopBuildService();
        static::expectException(GroupIsNotWorkshopParticipantException::class);
        $workShopBuildService->start($worksShopModel, $user, $this->prepareGroup($user));
    }

    /**
     * @return void
     * @throws GroupIsNotWorkshopParticipantException
     * @throws ORMException
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws Exception
     */
    public function testStartWorkshopWithoutQuestionsException(): void
    {
        $user = $this->prepareUser();
        $groupModel = $this->prepareGroup($user);
        $worksShopModel = $this->prepareWorkShopModel(true, false);
        $workShopBuildService = $this->prepareWorkShopBuildService();
        static::expectException(GroupIsNotWorkshopParticipantException::class);
        $workShopBuildService->start($worksShopModel, $user, $groupModel);
    }

    /**
     * @return void
     * @throws GroupIsNotWorkshopParticipantException
     * @throws ORMException
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws Exception
     */
    public function testStartWorkshopWithoutExercisesException(): void
    {
        $user = $this->prepareUser();
        $groupModel = $this->prepareGroup($user);
        $worksShopModel = $this->prepareWorkShopModel(true, true, false);
        $workShopBuildService = $this->prepareWorkShopBuildService();
        static::expectException(GroupIsNotWorkshopParticipantException::class);
        $workShopBuildService->start($worksShopModel, $user, $groupModel);
    }

    /**
     * @return void
     * @throws Exception|ORMException
     */
    public function testStartWorkshopWithoutGroupParticipants()
    {
        $user = $this->prepareUser();
        $worksShopModel = $this->prepareWorkShopModel(true, true, true);
        $workShopBuildService = $this->prepareWorkShopBuildService();
        static::expectException(GroupIsNotWorkshopParticipantException::class);
        $workShopBuildService->start(
            $worksShopModel,
            $user,
            $this->prepareGroup($user)
        );
    }

    /**
     * @return void
     * @throws Exception|ORMException
     */
    public function testStartWorkshop()
    {
        $user = $this->prepareUser();
        $group = $this->prepareGroup($user);
        $worksShopModel = $this->prepareWorkShopModel(true, true, true, $group);
        $workShopBuildService = $this->prepareWorkShopBuildService();
        $result = $workShopBuildService->start(
            $worksShopModel,
            $user,
            $this->prepareGroup($user)
        );
        static::assertInstanceOf(WorkShop::class, $result);
        static::assertObjectHasProperty('id', $result);
        static::assertIsInt($result->getId());
    }

    /**
     * @return User
     */
    private function prepareUser(): User
    {
        $user = new User();
        $user->setId(2);

        return $user;
    }

    /**
     * @param bool $withAnswers
     * @param bool $withQuestions
     * @param bool $withExercises
     * @param null|GroupModel $groupModel
     *
     * @return WorkShopModel
     */
    private function prepareWorkShopModel(
        bool $withAnswers = true,
        bool $withQuestions = true,
        bool $withExercises = true,
        ?GroupModel $groupModel = null
    ): WorkShopModel {
        return new WorkShopModel(
            id: 1,
            title: 'testStartWorkShop',
            description: 'testStartWorkShop description',
            createdAt: (new \DateTime())->modify('-5 days'),
            updatedAt: (new \DateTime())->modify('-1 day'),
            author: new WorkShopAuthorModel(
                id: 11,
                firstName: 'workshop author first name',
                lastName: 'workshop author last name',
                middleName: null
            ),
            exercises: $withExercises ? [
                new ExerciseModel(
                    id: 4,
                    title: 'Exercise testStartWorkShop',
                    content: 'Exercise testStartWorkShop content',
                    questions: $withQuestions ? [
                        new QuestionModel(
                            id: 5,
                            title: 'Question title',
                            description: 'Question description',
                            answers: $withAnswers ? [
                                new AnswerModel(
                                    id: 6,
                                    title: 'Answer title',
                                    description: 'Answer title'
                                )
                            ] : [],
                        )
                    ] : [],
                )
            ] : [],
            groupParticipants: $groupModel ? [$groupModel] : []
        );
    }

    /**
     * @param User $user
     *
     * @return GroupModel
     */
    private function prepareGroup(User $user): GroupModel
    {
        return new GroupModel(
            id: 3,
            name: 'group testStartWorkShop',
            isActive: true,
            workingFrom: (new \DateTime())->modify('-3 days'),
            workingTo: (new \DateTime())->modify('+1 year'),
            createdAt: (new \DateTime())->modify('-1 month'),
            updatedAt: (new \DateTime())->modify('-3 days'),
            participants: [$user]
        );
    }

    /**
     * @throws RuntimeException
     * @throws ReflectionException
     */
    private function prepareWorkShopBuildService(): WorkshopBuildService
    {
        $revisionBuildService = Mockery::mock(RevisionBuildService::class);
        $revisionBuildService->shouldReceive('buildRevisions');

        $workShopRepository = Mockery::mock(WorkShopRepository::class);
        $workShop = new WorkShop();
        $workShop->setId(11);
        $workShopRepository->shouldReceive('findById')
            ->andReturn($workShop)
            ->getMock()
            ->expects('refresh')
        ;

        $startWorkShopBus = Mockery::mock(StartWorkshopBusInterface::class);
        $startWorkShopBus->expects('sendFlushWorkShopCacheMessage');

        return new WorkshopBuildService(
            fixationService: Mockery::mock(FixationService::class),
            revisionBuildService: $revisionBuildService,
            fixationUserService: Mockery::mock(FixationUserService::class),
            fixationGroupService: Mockery::mock(FixationGroupService::class),
            startWorkshopBus: $startWorkShopBus,
            workShopRepository: $workShopRepository
        );
    }
}
