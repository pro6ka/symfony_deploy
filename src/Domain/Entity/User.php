<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Contracts\EntityInterface;
use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Contracts\HasMetaTimeStampInterface;
use App\Domain\Entity\Contracts\HasRevisionsInterface;
use App\Domain\ValueObject\AppRolesEnum;
use App\Domain\ValueObject\UserRoleEnum;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UnexpectedValueException;

#[ORM\Table(name: '`user`')]
#[ORM\Entity]
#[UniqueEntity(fields: ['email'], message: 'This value {{ value }} is already used')]
#[UniqueEntity(fields: ['login'], message: 'This value {{ value }} is already used')]
#[ORM\UniqueConstraint(name: 'user__email_unique', columns: ['email'])]
#[ORM\UniqueConstraint(name: 'user__login_unique', columns: ['login'])]
#[ORM\UniqueConstraint(name: 'user__token_unique', columns: ['token'])]
class User implements
    EntityInterface,
    HasMetaTimeStampInterface,
    HasFixationsInterface,
    HasRevisionsInterface,
    UserInterface,
    PasswordAuthenticatedUserInterface
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
    private ?string $middleName;

    #[ORM\Column(type: 'string', length: 100, unique: true, nullable: false)]
    private string $email;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'participants')]
    private Collection $groups;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(targetEntity: WorkShop::class, mappedBy: 'author')]
    private Collection $createdWorkShops;

    #[ORM\ManyToMany(targetEntity: WorkShop::class, mappedBy: 'students')]
    private Collection $participatedWorkShops;

    #[ORM\Column(name: 'user_role', type: 'userRole', nullable: true)]
    private ?UserRoleEnum $userRole = null;

    #[ORM\Column(name: 'app_roles', type: 'json', length: 1024, nullable: false, options: ['default' => '{}'])]
    private array $appRoles = [];

    #[ORM\Column(name: 'password', type: 'string', nullable: false, options: ['default' => ''])]
    private string $password;

    #[ORM\Column(name: 'token', type: 'string', length: 32, unique: true, nullable: true)]
    private ?string $token = null;

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
    public function getFirstName(): string
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
     * @param ?string $middleName
     *
     * @return void
     */
    public function setMiddleName(?string $middleName): void
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
     * @param Group $group
     *
     * @return void
     */
    public function leaveGroup(Group $group): void
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
        }
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
     * @throws UnexpectedValueException
     */
    public function addCreatedWorkSHop(WorkShop $workShop): void
    {
        if (! $this->createdWorkShops->contains($workShop)) {
            $this->createdWorkShops->add($workShop);
        }
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getParticipatedWorkShops(): ArrayCollection|Collection
    {
        return $this->participatedWorkShops;
    }

    /**
     * @param PersistentCollection $participatedWorkShops
     *
     * @return void
     */
    public function setParticipatedWorkShops(PersistentCollection $participatedWorkShops): void
    {
        $this->participatedWorkShops = $participatedWorkShops;
    }

    /**
     * @param WorkShop $workShop
     *
     * @return void
     * @throws UnexpectedValueException
     */
    public function addParticipatedWorkShop(WorkShop $workShop): void
    {
        if (! $this->participatedWorkShops->contains($workShop)) {
            $this->participatedWorkShops->add($workShop);
        }
    }

    /**
     * @return Collection
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    /**
     * @param Collection $groups
     *
     * @return void
     */
    public function setGroups(Collection $groups): void
    {
        $this->groups = $groups;
    }

    /**
     * @return null|UserRoleEnum
     */
    public function getUserRole(): ?UserRoleEnum
    {
        return $this->userRole;
    }

    /**
     * @param null|UserRoleEnum $userRole
     *
     * @return void
     */
    public function setUserRole(?UserRoleEnum $userRole): void
    {
        $this->userRole = $userRole;
    }

    /**
     * @return array|string[]
     */
    public function getAppRoles(): array
    {
        $roles = $this->appRoles;
        $roles[] = AppRolesEnum::ROLE_USER->value;
        return array_unique($roles);
    }

    /**
     * @param array|string[] $appRoles
     *
     * @return void
     */
    public function setAppRoles(array $appRoles): void
    {
        $this->appRoles = $appRoles;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return $this->getAppRoles();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * @inheritDoc
     */
    public function getUserIdentifier(): string
    {
        return $this->login;
    }

    /**
     * Returns the hashed password used to authenticate the user.
     *
     * Usually on authentication, a plain-text password will be compared to this value.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return null|string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param null|string $token
     *
     * @return void
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }
}
