<?php

namespace App\Application\Doctrine;

use App\Domain\Entity\Contracts\HasMetaTimeStampInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsDoctrineListener(event: Events::prePersist, connection: 'default')]
class MetaTimestampsPrePersistEventListener
{
    /**
     * @param LifecycleEventArgs $event
     *
     * @return void
     */
    public function prePersist(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof HasMetaTimeStampInterface) {
            $entity->setCreatedAt();
            $entity->setUpdatedAt();
        }
    }
}
