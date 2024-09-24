<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Contracts\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user_fixation')]
class UserFixation implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userFixations')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Fixation::class, inversedBy: 'fixationUsers')]
    private Fixation $fixation;

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
     * @param Fixation $fixation
     *
     * @return void
     */
    public function setFixation(Fixation $fixation): void
    {
        $this->fixation = $fixation;
    }
}
