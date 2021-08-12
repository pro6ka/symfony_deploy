<?php

namespace App\Entity;

use App\Repository\FilterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\FilterType")
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
     * @ORM\ManyToMany(targetEntity=Quota::class, mappedBy="filters")
     */
    private $quotas;

    public function __construct()
    {
        $this->quotas = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilterType(): ?FilterType
    {
        return $this->filterType;
    }

    public function setFilterType(?FilterType $filterType): self
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
            'filterType' => $this->filterType

        ];
    }

    /**
     * @return Collection|Quota[]
     */
    public function getQuotas(): Collection
    {
        return $this->quotas;
    }

    public function addQuota(Quota $quota): self
    {
        if (!$this->quotas->contains($quota)) {
            $this->quotas[] = $quota;
            $quota->addFilter($this);
        }

        return $this;
    }

    public function removeQuota(Quota $quota): self
    {
        if ($this->quotas->removeElement($quota)) {
            $quota->removeFilter($this);
        }

        return $this;
    }

}
