<?php

namespace App\Domain\Service;

use App\Domain\Bus\DeleteRevisionableBusInterface;
use App\Domain\Entity\Answer;
use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Question;
use App\Domain\Trait\RevisionableTrait;
use App\Infrastructure\Repository\AnswerRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class AnswerService extends AbstractFixableService
{
    use RevisionableTrait;

    /**
     * @param FixationService $fixationService
     * @param RevisionService $revisionService
     * @param AnswerRepository $answerRepository
     * @param DeleteRevisionableBusInterface $deleteRevisionableBus
     */
    public function __construct(
        private FixationService $fixationService,
        private RevisionService $revisionService,
        private AnswerRepository $answerRepository,
        private DeleteRevisionableBusInterface $deleteRevisionableBus
    ) {
    }

    /**
     * @param string $title
     * @param string $description
     * @param Question $question
     *
     * @return Answer
     */
    public function create(string $title, string $description, Question $question): Answer
    {
        $answer = new Answer();
        $answer->setTitle($title);
        $answer->setDescription($description);
        $answer->setQuestion($question);
        $this->answerRepository->create($answer);

        return $answer;
    }

    /**
     * @param int $entityId
     *
     * @return null|Answer
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $entityId): ?Answer
    {
        return $this->answerRepository->findById($entityId);
    }

    /**
     * @param int $answerId
     * @param int $userId
     * @param int $groupId
     *
     * @return null|Answer|RevisionableInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getByIdForUser(int $answerId, int $userId, int $groupId): Answer|RevisionableInterface|null
    {
        $answer = $this->answerRepository->findById($answerId);
        $revisions = $this->findRevisionsByFixable(
            entity: $answer,
            userId: $userId,
            groupId: $groupId
        );

        return $this->revisionService->applyToEntity($answer, $revisions);
    }

    /**
     * @return FixationService
     */
    protected function getFixationService(): FixationService
    {
        return $this->fixationService;
    }

    /**
     * @inheritDoc
     */
    protected function getRevisionService(): RevisionService
    {
        return $this->revisionService;
    }
}
