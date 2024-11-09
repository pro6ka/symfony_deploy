<?php

namespace App\Domain\Service;

use App\Domain\Contract\FixableModelInterface;
use App\Domain\Entity\Contracts\HasRevisionsInterface;
use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Entity\Revision;
use App\Infrastructure\Repository\RevisionRepository;

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
     * @param string $contentAfter
     *
     * @param string $contentBefore
     *
     * @return Revision
     */
    public function create(
        RevisionableInterface $entity,
        string $columnName,
        string $contentAfter,
        string $contentBefore = '',
    ): Revision {
        $revision = new Revision();
        $revision->setEntityId($entity->getId());
        $revision->setEntityType($entity::class);
        $revision->setColumnName($columnName);
        $revision->setContentBefore($contentBefore);
        $revision->setContentAfter($contentAfter);
        $this->revisionRepository->create($revision);

        return $revision;
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
     * @param array $revisions
     *
     * @return RevisionableInterface
     */
    public function applyToEntity(RevisionableInterface $entity, array $revisions): RevisionableInterface
    {
        if (isset($revisions[$entity->getId()]) && $revisions[$entity->getId()]) {
            $revisionColumns = $revisions[$entity->getId()];
            foreach ($entity->revisionableFields() as $field) {
                /** @var Revision $revision */
                $revision = $revisionColumns[$field];
                if (isset($revisionColumns[$field])) {
                    $setter = 'set' . ucfirst($revision->getColumnName());
                    if (method_exists($entity, $setter)) {
                        $entity->$setter($revision->getContentAfter());
                    }
                }
            }
        }

        return $entity;
    }

    /**
     * @param FixableModelInterface $entity
     *
     * @return array|Revision[]
     */
    public function findLastForEntity(FixableModelInterface $entity): array
    {
        return $this->revisionRepository->findLastForEntity($entity);
    }
}
