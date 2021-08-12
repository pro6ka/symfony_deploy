<?php

namespace App\Entity;

use App\Repository\MpollRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MpollRepository::class)
 * @ORM\Table(name="mpolls")
 */
class Mpoll
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $mstatus;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $startedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $endedAt;

    /**
     * @ORM\Column(type="decimal", nullable=false, precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $clicks;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $repeatable = false;

    /**
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $lenght;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $survLimit;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $prescreener;

    /**
     * @ORM\Column(type="string", length=1024, nullable=false)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $filename;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inCabinet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cab_link;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $complites;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $overquotas;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $screenouts;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $checkGeo = true;

    /**
     * @ORM\OneToMany(targetEntity=MpollDetail::class, mappedBy="mpolls")
     */
    private $mpollDetails;

    public function __construct()
    {
        $this->mpollDetails = new ArrayCollection();
    }








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

    public function getMstatus(): ?string
    {
        return $this->mstatus;
    }

    public function setMstatus(string $mstatus): self
    {
        $this->mstatus = $mstatus;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTimeImmutable $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }

    public function setEndedAt(?\DateTimeImmutable $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

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

    public function getClicks(): ?int
    {
        return $this->clicks;
    }

    public function setClicks(?int $clicks): self
    {
        $this->clicks = $clicks;

        return $this;
    }

    public function getRepeatable(): ?bool
    {
        return $this->repeatable;
    }

    public function setRepeatable(?bool $repeatable): self
    {
        $this->repeatable = $repeatable;

        return $this;
    }

    public function getLenght(): ?string
    {
        return $this->lenght;
    }

    public function setLenght(string $lenght): self
    {
        $this->lenght = $lenght;

        return $this;
    }

    public function getSurvLimit(): ?int
    {
        return $this->survLimit;
    }

    public function setSurvLimit(?int $survLimit): self
    {
        $this->survLimit = $survLimit;

        return $this;
    }

    public function getPrescreener(): ?string
    {
        return $this->prescreener;
    }

    public function setPrescreener(?string $prescreener): self
    {
        $this->prescreener = $prescreener;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getInCabinet(): ?bool
    {
        return $this->inCabinet;
    }

    public function setInCabinet(?bool $inCabinet): self
    {
        $this->inCabinet = $inCabinet;

        return $this;
    }

    public function getCabLink(): ?string
    {
        return $this->cab_link;
    }

    public function setCabLink(?string $cab_link): self
    {
        $this->cab_link = $cab_link;

        return $this;
    }

    public function getComplites(): ?int
    {
        return $this->complites;
    }

    public function setComplites(?int $complites): self
    {
        $this->complites = $complites;

        return $this;
    }

    public function getOverquotas(): ?int
    {
        return $this->overquotas;
    }

    public function setOverquotas(?int $overquotas): self
    {
        $this->overquotas = $overquotas;

        return $this;
    }

    public function getScreenouts(): ?int
    {
        return $this->screenouts;
    }

    public function setScreenouts(?int $screenouts): self
    {
        $this->screenouts = $screenouts;

        return $this;
    }

    public function getCheckGeo(): ?bool
    {
        return $this->checkGeo;
    }

    public function setCheckGeo(?bool $checkGeo): self
    {
        $this->checkGeo = $checkGeo;

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
            $mpollDetail->setMpolls($this);
        }

        return $this;
    }

    public function removeMpollDetail(MpollDetail $mpollDetail): self
    {
        if ($this->mpollDetails->removeElement($mpollDetail)) {
            // set the owning side to null (unless already changed)
            if ($mpollDetail->getMpolls() === $this) {
                $mpollDetail->setMpolls(null);
            }
        }

        return $this;
    }

}
