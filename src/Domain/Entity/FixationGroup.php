<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'fixation_group')]
#[ORM\UniqueConstraint(name: 'fixation_group__group_id__fixation_id_unique', columns: ['fixation_id', 'group_id'])]
class FixationGroup
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'bigint')]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: Group::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Group $group;

    #[ORM\ManyToOne(targetEntity: Fixation::class, inversedBy: 'group')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Fixation $fixation;

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group;
    }

    /**
     * @param Group $group
     *
     * @return void
     */
    public function setGroup(Group $group): void
    {
        $this->group = $group;
    }

    /**
     * @return Fixation
     */
    public function getFixation(): Fixation
    {
        return $this->fixation;
    }

    /**
     * @param Fixation|null $fixation
     *
     * @return void
     */
    public function setFixation(?Fixation $fixation): void
    {
        $this->fixation = $fixation;
    }

    /**
     * @param null|int $id
     *
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
