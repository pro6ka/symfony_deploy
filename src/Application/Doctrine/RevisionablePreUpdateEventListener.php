<?php

namespace App\Application\Doctrine;

use App\Domain\Entity\Contracts\RevisionableInterface;
use App\Domain\Service\RevisionService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsDoctrineListener(event: Events::preUpdate)]
readonly class RevisionablePreUpdateEventListener
{
    /**
     * @param RevisionService $revisionService
     */
    public function __construct(
        private RevisionService $revisionService
    ) {
    }

    /**
     * @param PreUpdateEventArgs $event
     *
     * @return void
     */
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof RevisionableInterface) {
            foreach ($entity->revisionableFields() as $field) {
                $entityFieldGetter = 'get' . $field;
                if ($event->hasChangedField($field)) {
                    $this->revisionService->create(
                        entity: $entity,
                        columnName: $field,
                        contentAfter: $event->getNewValue($field),
                        contentBefore: $entity->$entityFieldGetter()
                    );
                }
            }
        }
    }
}
