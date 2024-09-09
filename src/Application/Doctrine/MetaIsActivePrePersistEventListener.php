<?php

namespace App\Application\Doctrine;

use App\Domain\Entity\Contracts\HasMetaIsActiveInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsDoctrineListener(event: Events::prePersist, connection: 'default')]
class MetaIsActivePrePersistEventListener
{
    /**
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();

        if ($entity instanceof HasMetaIsActiveInterface) {
            $entity->setIsActive();
        }
    }
}
