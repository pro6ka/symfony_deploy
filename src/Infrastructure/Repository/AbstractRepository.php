<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Contracts\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

class AbstractRepository
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        protected readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return void
     */
    protected function flush(): void
    {
        $this->entityManager->flush();
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->flush();
    }

    /**
     * @param EntityInterface $entity
     *
     * @return int
     */
    protected function store(EntityInterface $entity): int
    {
        $this->entityManager->persist($entity);
        $this->flush();

        return $entity->getId();
    }

    /**
     * @param EntityInterface $entity
     *
     * @return void
     */
    protected function remove(EntityInterface $entity): void
    {
        $this->entityManager->remove($entity);
        $this->flush();
    }

    /**
     * @param EntityInterface $entity
     *
     * @return void
     * @throws ORMException
     */
    public function refresh(EntityInterface $entity): void
    {
        $this->entityManager->refresh($entity);
    }
}
