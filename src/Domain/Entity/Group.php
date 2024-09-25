<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Contracts\EntityInterface;
use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Contracts\HasMetaIsActiveInterface;
use App\Domain\Entity\Contracts\HasRevisionsInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Entity\Contracts\HasMetaTimeStampInterface;
use Doctrine\ORM\PersistentCollection;
use UnexpectedValueException;

#[ORM\Table(name: '`group`')]
#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'group__name_unique', columns: ['name'])]
class Group implements
    EntityInterface,
    HasMetaTimeStampInterface,
    HasMetaIsActiveInterface,
    HasRevisionsInterface,
    HasFixationsInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100, unique: true, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isActive;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private DateTime $workingFrom;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private DateTime $workingTo;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'groups')]
    private Collection $participants;

    #[ORM\ManyToMany(targetEntity: WorkShop::class, inversedBy: 'groupsParticipants')]
    private Collection $workshops;

    #[ORM\ManyToOne(targetEntity: Fixation::class, inversedBy: 'group_id')]
    private Collection $fixations;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->workshops = new ArrayCollection();
        $this->fixations = new ArrayCollection();
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     *
     * @return void
     */
    public function setIsActive(bool $isActive = false): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return DateTime
     */
    public function getWorkingFrom(): DateTime
    {
        return $this->workingFrom;
    }

    /**
     * @param DateTime $workingFrom
     *
     * @return void
     */
    public function setWorkingFrom(DateTime $workingFrom): void
    {
        $this->workingFrom = $workingFrom;
    }

    /**
     * @return DateTime
     */
    public function getWorkingTo(): DateTime
    {
        return $this->workingTo;
    }

    /**
     * @param DateTime $workingTo
     *
     * @return void
     */
    public function setWorkingTo(DateTime $workingTo): void
    {
        $this->workingTo = $workingTo;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return void
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }


    /**
     * @return void
     */
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * @param User $participant
     *
     * @return void
     */
    public function addParticipant(User $participant): void
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }
    }

    /**
     * @return PersistentCollection
     */
    public function getWorkshops(): PersistentCollection
    {
        return $this->workshops;
    }

    /**
     * @param PersistentCollection $workshops
     */
    public function setWorkshops(PersistentCollection $workshops): void
    {
        $this->workshops = $workshops;
    }

    /**
     * @param WorkShop $workShop
     *
     * @return void
     * @throws UnexpectedValueException
     */
    public function addWorkShop(WorkShop $workShop): void
    {
        if (! $this->workshops->contains($workShop)) {
            $this->workshops->add($workShop);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'isActive' => $this->isActive,
            'participants' => array_map(
                fn (User $participant) => $participant->toArray(),
                $this->participants->toArray()
            )
        ];
    }
}
