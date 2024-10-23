<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\Question;
use App\Domain\Model\Question\CreateQuestionModel;
use App\Infrastructure\Repository\QuestionRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class QuestionService extends AbstractFixableService
{
    /**
     * @param FixationService $fixationService
     * @param RevisionService $revisionService
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        private FixationService $fixationService,
        private RevisionService $revisionService,
        private QuestionRepository $questionRepository
    ) {
    }

    /**
     * @param CreateQuestionModel $createQuestionModel
     *
     * @return Question
     */
    public function create(CreateQuestionModel $createQuestionModel): Question
    {
        $question = new Question();
        $question->setTitle($createQuestionModel->title);
        $question->setDescription($createQuestionModel->description);
        $question->setExercise($createQuestionModel->exercise);

        $this->questionRepository->create($question);

        return $question;
    }

    /**
     * @param int $questionId
     *
     * @return null|Question
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $questionId): ?Question
    {
        return $this->questionRepository->findById($questionId);
    }

    /**
     * @param int $questionId
     * @param int $userId
     * @param int $groupId
     *
     * @return null|Question|RevisionableInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getByIdForUser(int $questionId, int $userId, int $groupId): Question|RevisionableInterface|null
    {
        $question = $this->questionRepository->findById($questionId);
        $revisions = $this->findRevisionsByFixable(
            entity: $question,
            userId: $userId,
            groupId: $groupId
        );

        return $this->revisionService->applyToEntity($question, $revisions);
    }

    /**
     * @return FixationService
     */
    protected function getFixationService(): FixationService
    {
        return $this->fixationService;
    }
}
