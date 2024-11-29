<?php

namespace App\Application\Doctrine;

use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Contracts\HasRevisionsInterface;
use App\Domain\Service\FixationService;
use App\Domain\Service\RevisionService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::preRemove)]
readonly class RevisionablePreRemoveEventListener
{
    /**
     * @param RevisionService $revisionService
     * @param FixationService $fixationService
     */
    public function __construct(
        private RevisionService $revisionService,
        private FixationService $fixationService
    ) {
    }

    /**
     * @param PreRemoveEventArgs $event
     *
     * @return void
     */
    public function preRemove(PreRemoveEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof HasRevisionsInterface) {
            $this->revisionService->removeByOwner($entity);
        }

        if ($entity instanceof HasFixationsInterface) {
            $this->fixationService->removeByOwner($entity);
        }
    }
}
