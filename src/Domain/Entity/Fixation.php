<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Contracts\EntityInterface;
use App\Domain\Entity\Contracts\HasMetaTimeStampInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'fixation')]
class Fixation implements EntityInterface, HasMetaTimeStampInterface
{
    #[ORM\Column(name: 'id', type: 'bigint')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    private DateTime $updatedAt;

    #[ORM\Column(name: 'entity_id', type: 'string')]
    private int $entityId;

    #[ORM\Column(name: 'entity_type', type: 'string')]
    private string $entityType;

    #[ORM\JoinTable(name: 'fixation_revision')]
    #[ORM\JoinColumn(name: 'fixation_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'revision_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Revision::class)]
    private Collection $revisions;

    #[ORM\Column(name: 'is_done', type: 'boolean', options: ['default' => false])]
    private bool $isDone = false;

    #[ORM\OneToMany(targetEntity: FixationUser::class, mappedBy: 'fixation')]
    private Collection $user;

    #[ORM\OneToMany(targetEntity: FixationGroup::class, mappedBy: 'fixation')]
    private Collection $group;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->group = new ArrayCollection();
        $this->revisions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->entityId;
    }

    /**
     * @param int $entityId
     *
     * @return void
     */
    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;
    }

    /**
     * @return string
     */
    public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * @param string $entityType
     *
     * @return void
     */
    public function setEntityType(string $entityType): void
    {
        $this->entityType = $entityType;
    }

    /**
     * @return Collection
     */
    public function getRevisions(): Collection
    {
        return $this->revisions;
    }

    /**
     * @param Revision $revision
     *
     * @return void
     */
    public function setRevision(Revision $revision): void
    {
        if (! $this->revisions->contains($revision)) {
            $this->revisions->add($revision);
        }
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }

    /**
     * @param bool $isDone
     *
     * @return void
     */
    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user->first();
    }

    /**
     * @param FixationUser $fixationUser
     *
     * @return void
     */
    public function setUser(FixationUser $fixationUser): void
    {
        if (! $this->user->contains($fixationUser)) {
            $this->user->clear();
            $this->user->add($fixationUser);
            $fixationUser->setFixation($this);
        }
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group->first();
    }

    /**
     * @param FixationGroup $fixationGroup
     *
     * @return void
     */
    public function setGroup(FixationGroup $fixationGroup): void
    {
        if (! $this->group->contains($fixationGroup)) {
            $this->group->clear();
            $this->group->add($fixationGroup);
            $fixationGroup->setFixation($this);
        }
    }
}
