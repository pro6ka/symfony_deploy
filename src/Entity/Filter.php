<?php

namespace App\Entity;

use App\Repository\FilterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilterRepository::class)
 */
class Filter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FilterType", inversedBy="filters")
     * @ORM\JoinColumn(name="filter_type_id", referencedColumnName="id")
     */
    private $filterType;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=4000, nullable=false)
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=4000, nullable=false)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Quota", inversedBy="filters")
     * @ORM\JoinTable(
     *     name="QuotaHasFilter",
     *     joinColumns={@ORM\JoinColumn(name="filter_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="quota_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $quotas;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilterType(): ?string
    {
        return $this->filterType;
    }

    public function setFilterType(string $filterType): self
    {
        $this->filterType = $filterType;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'value' => $this->value,
        ];
    }

}
