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
#[ORM\UniqueConstraint(name: 'fixation__revision_id__unique', columns: ['revision_id'])]
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

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'id') ]
    private Collection $user;

    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'id')]
    private Collection $group;

    #[ORM\Column(name: 'entity_id', type: 'string')]
    private int $entityId;

    #[ORM\Column(name: 'entity_type', type: 'string')]
    private string $entityType;

    #[ORM\OneToOne(targetEntity: Revision::class)]
    private Revision $revision;

    #[ORM\Column(name: 'is_done', type: 'boolean', options: ['default' => false])]
    private bool $isDone = false;

    public function __construct()
    {
        $this->group = new ArrayCollection();
        $this->user = new ArrayCollection();
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
     * @return Collection
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    /**
     * @param Collection $user
     *
     * @return void
     */
    public function setUser(Collection $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Collection
     */
    public function getGroup(): Collection
    {
        return $this->group;
    }

    /**
     * @param Collection $group
     *
     * @return void
     */
    public function setGroup(Collection $group): void
    {
        $this->group = $group;
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
     * @return Revision
     */
    public function getRevision(): Revision
    {
        return $this->revision;
    }

    /**
     * @param Revision $revision
     *
     * @return void
     */
    public function setRevision(Revision $revision): void
    {
        $this->revision = $revision;
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
}
