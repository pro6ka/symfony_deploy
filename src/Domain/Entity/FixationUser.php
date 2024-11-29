<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'fixation_user')]
#[ORM\UniqueConstraint(name: 'fixation_user__user_id__fixation_id_unique', columns: ['fixation_id', 'user_id'])]
class FixationUser
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'bigint')]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Fixation::class, inversedBy: 'user')]
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
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
