<?php

namespace App\Application\Doctrine;

use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Service\RevisionService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsDoctrineListener(event: Events::postPersist)]
readonly class RevisionablePostPersistEventListener
{
    /**
     * @param RevisionService $revisionService
     */
    public function __construct(
        private RevisionService $revisionService
    ) {
    }
    /**
     * @param LifecycleEventArgs $event
     *
     * @return void
     */
    public function prePersist(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof RevisionableInterface) {
            foreach ($entity->revisionableFields() as $field) {
                $getter = 'get' . $field;
                $this->revisionService->create(
                    $entity,
                    $field,
                    $entity->$getter(),
                );
            }
        }
    }
}
