<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Contracts\EntityInterface;
use App\Domain\Entity\Contracts\HasMetaTimeStampInterface;
use App\Domain\Entity\Contracts\RevisionableInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'work_shop')]
#[ORM\Index(name: 'work_shop__author_id_idx', fields: ['author'])]
class WorkShop implements EntityInterface, HasMetaTimeStampInterface, RevisionableInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'title', type: 'string', length: 100)]
    private string $title;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private string $description;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    private DateTime $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'createdWorkShops')]
    #[ORM\JoinColumn(name: 'author_id', referencedColumnName: 'id')]
    private User $author;

    #[ORM\OneToMany(targetEntity: Exercise::class, mappedBy: 'workShop')]
    private ArrayCollection $exercises;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'participatedWorkShops')]
    private ArrayCollection $students;

    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'workshops')]
    private ArrayCollection $groupsParticipants;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
        $this->groupsParticipants = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function setAuthor(User $user): void
    {
        $this->author = $user;
    }

    /**
     * @return ArrayCollection
     */
    public function getExercises(): ArrayCollection
    {
        return $this->exercises;
    }

    /**
     * @param ArrayCollection $exercises
     *
     * @return void
     */
    public function setExercises(ArrayCollection $exercises): void
    {
        $this->exercises = $exercises;
    }

    /**
     * @param Exercise $exercise
     *
     * @return void
     */
    public function addExercise(Exercise $exercise): void
    {
        if (! $this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getGroupsParticipants(): ArrayCollection
    {
        return $this->groupsParticipants;
    }

    /**
     * @param ArrayCollection $groupsParticipants
     *
     * @return void
     */
    public function setGroupsParticipants(ArrayCollection $groupsParticipants): void
    {
        $this->groupsParticipants = $groupsParticipants;
    }

    /**
     * @param Group $group
     *
     * @return void
     */
    public function addGroupParticipant(Group $group): void
    {
        if (! $this->groupsParticipants->contains($group)) {
            $this->groupsParticipants->add($group);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getStudents(): ArrayCollection
    {
        return $this->students;
    }

    /**
     * @param ArrayCollection $students
     *
     * @return void
     */
    public function setStudents(ArrayCollection $students): void
    {
        $this->students = $students;
    }

    /**
     * @param User $student
     *
     * @return void
     */
    public function addStudent(User $student): void
    {
        if (! $this->students->contains($student)) {
            $this->students->add($student);
        }
    }

    /**
     * @return array
     */
    public function revisionableFields(): array
    {
        return ['title', 'description',];
    }
}
