<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\HasRevisionsInterface;
use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Revision;
use App\Infrastructure\Repository\RevisionRepository;
use Doctrine\ORM\NonUniqueResultException;

readonly class RevisionService
{
    /**
     * @param RevisionRepository $revisionRepository
     */
    public function __construct(
        private RevisionRepository $revisionRepository
    ) {
    }


    /**
     * @param RevisionableInterface $entity
     * @param string $columnName
     * @param string $contentBefore
     * @param string $contentAfter
     *
     * @return array
     */
    public function create(
        RevisionableInterface $entity,
        string $columnName,
        string $contentAfter,
        string $contentBefore = '',
    ): array {
        $revision = new Revision();
        $revision->setEntityId($entity->getId());
        $revision->setEntityType($entity::class);
        $revision->setColumnName($columnName);
        $revision->setContentBefore($contentBefore);
        $revision->setContentAfter($contentAfter);
        $this->revisionRepository->create($revision);

        return $revision->toArray();
    }

    /**
     * @param HasRevisionsInterface $entity
     *
     * @return void
     */
    public function removeByOwner(HasRevisionsInterface $entity): void
    {
        $this->revisionRepository->removeByEntity($entity);
    }

    /**
     * @param RevisionableInterface $entity
     *
     * @return array|Revision[]
     */
    public function findLastForEntity(RevisionableInterface $entity): array
    {
        return $this->revisionRepository->findLastForEntity($entity);
    }
}
