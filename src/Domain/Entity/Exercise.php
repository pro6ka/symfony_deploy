<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Contracts\EntityInterface;
use App\Domain\Entity\Contracts\FixableInterface;
use App\Domain\Entity\Contracts\HasMetaTimeStampInterface;
use App\Domain\Entity\Contracts\RevisionableInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'exercise')]
#[ORM\Index(name: 'exercise__workshop_id_idx', columns: ['workshop_id'])]
class Exercise implements EntityInterface, HasMetaTimeStampInterface, RevisionableInterface, FixableInterface
{
    #[ORM\Column(name: 'id', type: 'bigint')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    private DateTime $updatedAt;

    #[ORM\Column(name: 'title', type: 'string', length: 100)]
    private string $title;

    #[ORM\Column(name: 'content', type: 'text')]
    private string $content;

    #[ORM\ManyToOne(targetEntity: WorkShop::class, inversedBy: 'exercises')]
    #[ORM\JoinColumn(name: 'workshop_id', referencedColumnName: 'id')]
    private WorkShop $workShop;

    #[ORM\OneToMany(targetEntity: Question::class, mappedBy: 'exercise')]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    /**
     * @inheritDoc
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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return WorkShop
     */
    public function getWorkShop(): WorkShop
    {
        return $this->workShop;
    }

    /**
     * @param WorkShop $workShop
     *
     * @return void
     */
    public function setWorkShop(WorkShop $workShop): void
    {
        $this->workShop = $workShop;
    }

    /**
     * @return Collection
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    /**
     * @param Collection $questions
     *
     * @return void
     */
    public function setQuestions(Collection $questions): void
    {
        $this->questions = $questions;
    }

    /**
     * @param Question $question
     *
     * @return void
     */
    public function addQuestion(Question $question): void
    {
        if (! $this->questions->contains($question)) {
            $this->questions->add($question);
        }
    }

    /**
     * @return array
     */
    public function revisionableFields(): array
    {
        return ['title', 'content',];
    }
}
