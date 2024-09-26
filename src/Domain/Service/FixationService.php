<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\FixableInterface;
use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Fixation;
use App\Domain\Entity\Group;
use App\Domain\Entity\Revision;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\FixationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;

readonly class FixationService
{
    /**
     * @param FixationRepository $fixationRepository
     */
    public function __construct(
        private FixationRepository $fixationRepository
    ) {
    }

    /**
     * @param HasFixationsInterface $user
     *
     * @return void
     */
    public function removeByOwner(HasFixationsInterface $user): void
    {
        $this->fixationRepository->removeByOwner($user);
    }

    /**
     * @param User $user
     * @param string $entityType
     *
     * @return ArrayCollection|array
     */
    public function findForUser(User $user, string $entityType): ArrayCollection|array
    {
        return $this->fixationRepository->findForUser($user, $entityType);
    }

    /**
     * @param Group $group
     * @param FixableInterface $entity
     *
     * @return null|Fixation
     * @throws NonUniqueResultException
     */
    public function hasGroupFixation(Group $group, FixableInterface $entity): ?Fixation
    {
        return $this->fixationRepository->hasGroupFixation($group, $entity);
    }

    /**
     * @param FixableInterface $entity
     * @param User $user
     * @param Revision $revision
     * @param Group $group
     *
     * @return Fixation
     */
    public function build(
        FixableInterface $entity,
        User $user,
        Revision $revision,
        Group $group
    ): Fixation {
        $fixation = new Fixation();
        $fixation->setEntityId($entity->getId());
        $fixation->setEntityType($entity::class);
        $fixation->setRevision($revision);
        $fixation->setGroup($group);
        $fixation->setUser($user);

        $this->fixationRepository->create($fixation, false);

        return $fixation;
    }
}
