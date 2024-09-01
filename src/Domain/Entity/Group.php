<?php


use App\Domain\Entity\Contracts\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'group')]
#[ORM\Entity]
class Group implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $isActive;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \App\Domain\Entity\DateTime $workingFrom;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private DateTime $workingTo;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'groups')]
    private Collection $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
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
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return \App\Domain\Entity\DateTime
     */
    public function getWorkingFrom(): \App\Domain\Entity\DateTime
    {
        return $this->workingFrom;
    }

    /**
     * @param \App\Domain\Entity\DateTime $workingFrom
     *
     * @return void
     */
    public function setWorkingFrom(\App\Domain\Entity\DateTime $workingFrom): void
    {
        $this->workingFrom = $workingFrom;
    }

    /**
     * @return \App\Domain\Entity\DateTime
     */
    public function getWorkingTo(): \App\Domain\Entity\DateTime
    {
        return $this->workingTo;
    }

    /**
     * @param \App\Domain\Entity\DateTime $workingTo
     *
     * @return void
     */
    public function setWorkingTo(\App\Domain\Entity\DateTime $workingTo): void
    {
        $this->workingTo = $workingTo;
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
}
