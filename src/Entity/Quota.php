<?php

namespace App\Entity;

use App\Repository\QuotaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuotaRepository::class)
 * @ORM\Table(name="quotas")
 */
class Quota
{

    public function __construct()
    {
        $this->filters = new ArrayCollection();
        $this->mpollDetails = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Filter::class, inversedBy="quotas")
     */
    private $filters;

    /**
     * @ORM\OneToMany(targetEntity=MpollDetail::class, mappedBy="quotas")
     */
    private $mpollDetails;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Filter[]
     */
    public function getFilters(): Collection
    {
        return $this->filters;
    }

    public function addFilter(Filter $filter): self
    {
        if (!$this->filters->contains($filter)) {
            $this->filters[] = $filter;
        }

        return $this;
    }

    public function removeFilter(Filter $filter): self
    {
        $this->filters->removeElement($filter);

        return $this;
    }

    /**
     * @return Collection|MpollDetail[]
     */
    public function getMpollDetails(): Collection
    {
        return $this->mpollDetails;
    }

    public function addMpollDetail(MpollDetail $mpollDetail): self
    {
        if (!$this->mpollDetails->contains($mpollDetail)) {
            $this->mpollDetails[] = $mpollDetail;
            $mpollDetail->setQuotas($this);
        }

        return $this;
    }

    public function removeMpollDetail(MpollDetail $mpollDetail): self
    {
        if ($this->mpollDetails->removeElement($mpollDetail)) {
            // set the owning side to null (unless already changed)
            if ($mpollDetail->getQuotas() === $this) {
                $mpollDetail->setQuotas(null);
            }
        }

        return $this;
    }
}
