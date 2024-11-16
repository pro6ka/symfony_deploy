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
use App\Domain\Service\RevisionService;

trait RevisionableTrait
{
    /**
     * @param int $entityId
     *
     * @return null|RevisionableInterface
     */
    abstract public function findById(int $entityId): ?RevisionableInterface;

    /**
     * @return RevisionService
     */
    abstract protected function getRevisionService(): RevisionService;

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
     * @param FixableInterface|RevisionableInterface|HasRevisionsInterface $entity
     *
     * @return void
     * @throws EntityHasFixationsException
     */
    public function deleteRevisionable(
        FixableInterface|RevisionableInterface|HasRevisionsInterface $entity
    ): void {
        if ($this->fixationService->findByEntity($entity)) {
            throw new EntityHasFixationsException($entity);
        }

        $this->getRevisionService()->removeByOwner($entity);
    }
}
