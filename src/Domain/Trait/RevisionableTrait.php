<?php

namespace App\Domain\Trait;

use App\Domain\Bus\DeleteRevisionableBusInterface;
use App\Domain\DTO\DeleteRevisionableDTO;
use App\Domain\Entity\Answer;
use App\Domain\Entity\Contracts\FixableInterface;
use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Contracts\HasRevisionsInterface;
use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Exception\EntityHasFixationsException;

trait RevisionableTrait
{
    /**
     * @param int $entityId
     *
     * @return null|RevisionableInterface
     */
    abstract public function findById(int $entityId): ?RevisionableInterface;

    /**
     * @param RevisionableInterface $entity
     *
     * @return void
     */
    public function deleteAsync(RevisionableInterface $entity): void
    {
        $this->deleteRevisionableBus->sendDeleteRevisionableMessage(
            new DeleteRevisionableDTO(
                entityId: $entity->getId(),
                routingKey: $entity::class
            )
        );
    }

    /**
     * @param FixableInterface|RevisionableInterface|HasRevisionsInterface|Answer $entity
     *
     * @return void
     * @throws EntityHasFixationsException
     */
    public function deleteRevisionable(
        FixableInterface|RevisionableInterface|HasRevisionsInterface|Answer $entity
    ): void {
        if ($this->fixationService->findByEntity($entity)) {
            throw new EntityHasFixationsException($entity);
        }

        $this->revisionService->removeByOwner($entity);
        $this->answerRepository->removeAnswer($entity);
    }
}
