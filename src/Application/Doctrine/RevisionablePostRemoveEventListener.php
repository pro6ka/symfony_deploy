<?php

namespace App\Application\Doctrine;

use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Contracts\HasRevisionsInterface;
use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Service\FixationService;
use App\Domain\Service\RevisionService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::preRemove)]
readonly class RevisionablePostRemoveEventListener
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
     * @param PostRemoveEventArgs $event
     *
     * @return void
     */
    public function preRemove(PostRemoveEventArgs $event): void
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
