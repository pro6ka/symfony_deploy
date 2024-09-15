<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Contracts\EntityInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'revision')]
#[ORM\HasLifecycleCallbacks]
class Revision implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint')]
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    private ?int $id;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(name: 'entity_id', type: 'string')]
    private string $entityId;

    #[ORM\Column(name: 'entity_type', type: 'string')]
    private string $entityType;

    #[ORM\Column(name: 'column_name', type: 'string')]
    private string $columnName;

    #[ORM\Column(name: 'content_before', type: 'string')]
    private $contentBefore;

    #[ORM\Column(name: 'content_after', type: 'string')]
    private $contentAfter;

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
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return void
     */
    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }
}
