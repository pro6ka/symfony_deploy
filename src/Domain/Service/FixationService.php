<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\FixableInterface;
use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Fixation;
use App\Domain\Entity\FixationGroup;
use App\Domain\Entity\FixationUser;
use App\Domain\Entity\Group;
use App\Domain\Entity\Revision;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\FixationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use RuntimeException;

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
     * @return array
     */
    public function hasGroupFixation(Group $group, FixableInterface $entity): array
    {
        return $this->fixationRepository->hasGroupFixation($group, $entity);
    }

    /**
     * @param FixableInterface $entity
     * @param FixationUser $fixationUser
     * @param Revision $revision
     * @param FixationGroup $fixationGroup
     *
     * @return Fixation
     * @throws RuntimeException
     */
    public function build(
        FixableInterface $entity,
        FixationUser $fixationUser,
        Revision $revision,
        FixationGroup $fixationGroup
    ): Fixation {
        if (
            $fixation = $this->findByFullCriteria(
                $entity,
                $fixationUser->getUser(),
                $revision,
                $fixationGroup->getGroup()
            )
        ) {
            return $fixation;
        }

        $fixation = $this->make($entity, $fixationUser, $revision, $fixationGroup);
        $this->fixationRepository->create($fixation, false);

        return $fixation;
    }

    /**
     * @param FixableInterface $entity
     * @param User $user
     * @param Revision $revision
     * @param Group $group
     *
     * @return null|Fixation
     * @throws RuntimeException
     */
    public function findByFullCriteria(
        FixableInterface $entity,
        User $user,
        Revision $revision,
        Group $group
    ): ?Fixation {
        return $this->fixationRepository->findByFullCriteria(
            $entity,
            $user,
            $revision,
            $group
        );
    }

    /**
     * @param FixableInterface $entity
     * @param FixationUser $fixationUser
     * @param Revision $revision
     * @param FixationGroup $fixationGroup
     *
     * @return Fixation
     * @throws RuntimeException
     */
    public function create(
        FixableInterface $entity,
        FixationUser $fixationUser,
        Revision $revision,
        FixationGroup $fixationGroup
    ): Fixation {
        if (
            $fixation = $this->findByFullCriteria(
                $entity,
                $fixationUser->getUser(),
                $revision,
                $fixationGroup->getGroup()
            )
        ) {
            return $fixation;
        }

        $fixation = $this->build($entity, $fixationUser, $revision, $fixationGroup);
        $this->fixationRepository->create($fixation);

        return $fixation;
    }

    /**
     * @param FixableInterface $entity
     * @param int $userId
     * @param int $groupId
     *
     * @return array|Fixation[]
     */
    public function listForUserByEntity(FixableInterface $entity, int $userId, int $groupId): array
    {
        return $this->fixationRepository->listForUserByEntity(
            entityType: $entity::class,
            entityId: $entity->getId(),
            userId: $userId,
            groupId: $groupId
        );
    }

    /**
     * @param FixableInterface $entity
     * @param FixationUser $user
     * @param Revision $revision
     * @param FixationGroup $group
     *
     * @return Fixation
     */
    protected function make(
        FixableInterface $entity,
        FixationUser $user,
        Revision $revision,
        FixationGroup $group
    ): Fixation {
        $fixation = new Fixation();
        $fixation->setEntityId($entity->getId());
        $fixation->setEntityType($entity::class);
        $fixation->setRevision($revision);
        $fixation->setGroup($group);
        $fixation->setUser($user);

        return $fixation;
    }

    /**
     * @param User $user
     * @param Group $group
     * @param bool $immediate
     *
     * @return void
     */
    public function removeForUserByGroup(User $user, Group $group, bool $immediate = false): void
    {
        $fixations = $this->fixationRepository->findForUserByGroup($user, $group);

        /** @var Fixation $fixation */
        foreach ($fixations as $fixation) {
            $this->fixationRepository->drop($fixation, $immediate);
        }
    }
}
