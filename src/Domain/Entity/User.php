<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Contracts\EntityInterface;
use App\Domain\Entity\Contracts\HasMetaTimeStampInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: '`user`')]
#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'user__email_unique', columns: ['email'])]
#[ORM\UniqueConstraint(name: 'user__login_unique', columns: ['login'])]
class User implements EntityInterface, HasMetaTimeStampInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 32, unique: true, nullable: false)]
    private string $login;

    #[ORM\Column(type: 'string', length: 32, nullable: false)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 32, nullable: false)]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private string $middleName;

    #[ORM\Column(type: 'string', length: 100, unique: true, nullable: false)]
    private string $email;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'participants')]
    private Collection $groups;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity: WorkShop::class, mappedBy: 'author')]
    private ArrayCollection $createdWorkShops;

    #[ORM\ManyToMany(targetEntity: WorkShop::class, mappedBy: 'students')]
    private ArrayCollection $participatedWorkShops;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->createdWorkShops = new ArrayCollection();
        $this->participatedWorkShops = new ArrayCollection();
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
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     *
     * @return void
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return void
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return void
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName ?? '';
    }

    /**
     * @param string $middleName
     *
     * @return void
     */
    public function setMiddleName(string $middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
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
     * @param Group $group
     * @return void
     */
    public function addGroup(Group $group): void
    {
        if (! $this->groups->contains($group)) {
            $this->groups->add($group);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'middleName' => $this->getMiddleName(),
        ];
    }

    /**
     * @return Collection
     */
    public function getCreatedWorkShops(): Collection
    {
        return $this->createdWorkShops;
    }

    /**
     * @param ArrayCollection $workShops
     *
     * @return void
     */
    public function setWorkShops(ArrayCollection $workShops): void
    {
        $this->createdWorkShops = $workShops;
    }

    /**
     * @param WorkShop $workShop
     *
     * @return void
     */
    public function addCreatedWorkSHop(WorkShop $workShop): void
    {
        if (! $this->createdWorkShops->contains($workShop)) {
            $this->createdWorkShops->add($workShop);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getParticipatedWorkShops(): ArrayCollection
    {
        return $this->participatedWorkShops;
    }

    /**
     * @param ArrayCollection $participatedWorkShops
     *
     * @return void
     */
    public function setParticipatedWorkShops(ArrayCollection $participatedWorkShops): void
    {
        $this->participatedWorkShops = $participatedWorkShops;
    }

    /**
     * @param WorkShop $workShop
     *
     * @return void
     */
    public function addParticipatedWorkShop(WorkShop $workShop): void
    {
        if (! $this->participatedWorkShops->contains($workShop)) {
            $this->participatedWorkShops->add($workShop);
        }
    }
}
