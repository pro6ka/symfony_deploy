<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Question;
use App\Domain\Model\Question\CreateQuestionModel;
use App\Domain\Model\Question\EditQuestionModel;
use App\Domain\Model\Question\ListQuestionModel;
use App\Domain\Trait\PaginationTrait;
use App\Infrastructure\Repository\QuestionRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class QuestionService extends AbstractFixableService
{
    use PaginationTrait;

    /**
     * @param ValidatorInterface $validator
     * @param FixationService $fixationService
     * @param RevisionService $revisionService
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        private ValidatorInterface $validator,
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

        $violations = $this->validator->validate($question);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($question, $violations);
        }

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

    /**
     * @param Question $question
     * @param EditQuestionModel $editQuestionModel
     *
     * @return void
     */
    public function editQuestion(Question $question, EditQuestionModel $editQuestionModel): void
    {
        $question->setTitle($editQuestionModel->title ?? $question->getTitle());
        $question->setDescription($editQuestionModel->description ?? $question->getDescription());

        $violations = $this->validator->validate($question);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($violations, $question);
        }

        $this->questionRepository->update();
    }

    /**
     * @param int $page
     *
     * @return Paginator
     */
    public function getList(int $page): Paginator
    {
        return $this->questionRepository->getList(
            pageSize: ListQuestionModel::PAGE_SIZE,
            firstResult: $this->countOffset(page: $page, pageSize: ListQuestionModel::PAGE_SIZE)
        );
    }

    /**
     * @param Question $question
     *
     * @return void
     */
    public function deleteQuestion(Question $question): void
    {
        $this->questionRepository->removeQuestion($question);
    }
}
