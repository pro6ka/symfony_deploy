<?php

namespace App\Controller;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Service\AnswerService;
use App\Domain\Service\ExerciseService;
use App\Domain\Service\FixationService;
use App\Domain\Service\GroupBuildService;
use App\Domain\Service\GroupService;
use App\Domain\Service\QuestionService;
use App\Domain\Service\RevisionService;
use App\Domain\Service\UserService;
use App\Domain\Service\WorkshopBuildService;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use JetBrains\PhpStorm\NoReturn;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GroupController extends AbstractController
{
    /**
     * @param GroupService $groupService
     * @param GroupBuildService $groupBuildService
     * @param UserService $userService
     * @param WorkShopService $workShopService
     * @param WorkshopBuildService $workshopBuildService
     * @param ExerciseService $exerciseService
     * @param QuestionService $questionService
     * @param AnswerService $answerService
     */
    public function __construct(
        private readonly GroupService $groupService,
        private readonly GroupBuildService $groupBuildService,
        private readonly UserService $userService,
        private readonly WorkShopService $workShopService,
        private readonly WorkshopBuildService $workshopBuildService,
        private readonly ExerciseService $exerciseService,
        private readonly QuestionService $questionService,
        private readonly AnswerService $answerService
    ) {
    }

    /**
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/group/create')]
    public function create(): JsonResponse
    {
        $groupResult = $this->groupService->create('zero group');

        return $this->json([$groupResult]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route('/group/activate/{id}')]
    public function activate(int $id): JsonResponse
    {
        return $this->json($this->groupService->activate($id)->toArray());
    }

    /**
     * @param int $groupId
     * @param int $userId
     *
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route('/group/add-participant/{groupId}/{userId}')]
    public function addParticipant(int $groupId, int $userId): JsonResponse
    {
        return $this->json($this->groupBuildService->addParticipant($groupId, $userId));
    }

    /**
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NonUniqueResultException
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route('/group/rbowner')]
    public function removeByOwner(): JsonResponse
    {
        $user = $this->userService->find(2);
        $group = $this->groupService->find(2);
        /**
         * start workshop
        $group = $this->groupService->find(2);
        $workshop = $this->workShopService->findForUserById(2, $user);

        return $this->json($this->workshopBuildService->start($workshop, $user, $group));
        */
        /**
         * exercise create
         *
        $workshop = $this->workShopService->findById(3);
        $exercise = $this->exerciseService->create(
            title: 'first exercise for second workshop',
            content: 'content of first exercise for second workshop',
            workShop: $workshop
        );
        */
        /**
         * questions create
         *
        $exercise = $this->exerciseService->findById(5);
        $questions = [
            [
                'title' => 'first quest for fifth ex',
                'description' => 'first quest descr for fifth ex',
            ],
            [
                'title' => 'second quest for fifth ex',
                'description' => 'second quest descr for fifth ex',
            ]
        ];
        foreach ($questions as $question) {
            $questionResult = $this->questionService->create(
                title: $question['title'],
                description: $question['description'],
                exercise: $exercise
            );
            dump($questionResult);
        }
        */
        /**
         * answers create
         *
        $question = $this->questionService->findById(6);
        $answer = $this->answerService->create(
            title: 'anwsers title for sixth question',
            description: 'anwsers title for sixth question',
            question: $question
        );
        */
        $workshop = $this->workShopService->findById(3);
        /**
         * start sixth workshop
         *
        $workshop = $this->workShopService->findById(3);
        $result = $this->workshopBuildService->start($workshop, $user, $group);
        dump($result);
        die;
         */
        /**
         * find exercise by id in workshop for user
         */
        $exercise = $this->exerciseService->getByIdForUser(
            5,
            user: $user,
            group: $group
        );
        /**
        find exercises list for workshop
         *
//      $exercises = $this->exerciseService->findForWorkShop($workshop, $user, $group);
         */
        dump($exercise);
        die;
    }
}
