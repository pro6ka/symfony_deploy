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

    #[ORM\Column(name: 'content_before', type: 'string', nullable: true)]
    private string $contentBefore;

    #[ORM\Column(name: 'content_after', type: 'string')]
    private string $contentAfter;

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

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * @param string $entityId
     *
     * @return void
     */
    public function setEntityId(string $entityId): void
    {
        $this->entityId = $entityId;
    }

    /**
     * @return string
     */
    public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * @param string $entityType
     *
     * @return void
     */
    public function setEntityType(string $entityType): void
    {
        $this->entityType = $entityType;
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    /**
     * @param string $columnName
     *
     * @return void
     */
    public function setColumnName(string $columnName): void
    {
        $this->columnName = $columnName;
    }

    /**
     * @return string
     */
    public function getContentBefore(): string
    {
        return $this->contentBefore;
    }

    /**
     * @param string $contentBefore
     *
     * @return void
     */
    public function setContentBefore(string $contentBefore): void
    {
        $this->contentBefore = $contentBefore;
    }

    /**
     * @return string
     */
    public function getContentAfter(): string
    {
        return $this->contentAfter;
    }

    /**
     * @param string $contentAfter
     *
     * @return void
     */
    public function setContentAfter(string $contentAfter): void
    {
        $this->contentAfter = $contentAfter;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt,
            'entityId' => $this->entityId,
            'entityType' => $this->entityType,
            'columnName' => $this->columnName,
            'contentBefore' => $this->contentBefore,
            'contentAfter' => $this->contentAfter,
        ];
    }
}
