<?php

namespace App\Entity;

use App\Repository\QuotaDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuotaDetailRepository::class)
 */
class QuotaDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="Mpoll", inversedBy="quotadetailMpoll")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mpoll_id", referencedColumnName="id")
     * })
     */
    private Mpoll $mpoll;

    /**
     * @ORM\ManyToOne(targetEntity="Quota", inversedBy="quotadetailQuta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="quota_id", referencedColumnName="id")
     * })
     */
    private Quota $quota;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $send_posible;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sending;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sendOrder;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $prescreener;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $overquota;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $screenout;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $complete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompletes(): ?int
    {
        return $this->completes;
    }

    public function setCompletes(?int $completes): self
    {
        $this->completes = $completes;

        return $this;
    }

    public function getSent(): ?int
    {
        return $this->sent;
    }

    public function setSent(?int $sent): self
    {
        $this->sent = $sent;

        return $this;
    }

    public function getSendPosible(): ?int
    {
        return $this->send_posible;
    }

    public function setSendPosible(?int $send_posible): self
    {
        $this->send_posible = $send_posible;

        return $this;
    }

    public function getSending(): ?int
    {
        return $this->sending;
    }

    public function setSending(?int $sending): self
    {
        $this->sending = $sending;

        return $this;
    }

    public function getSendOrder(): ?string
    {
        return $this->sendOrder;
    }

    public function setSendOrder(string $sendOrder): self
    {
        $this->sendOrder = $sendOrder;

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

    public function getOverquota(): ?int
    {
        return $this->overquota;
    }

    public function setOverquota(?int $overquota): self
    {
        $this->overquota = $overquota;

        return $this;
    }

    public function getScreenout(): ?int
    {
        return $this->screenout;
    }

    public function setScreenout(?int $screenout): self
    {
        $this->screenout = $screenout;

        return $this;
    }

    public function getComplete(): ?int
    {
        return $this->complete;
    }

    public function setComplete(?int $complete): self
    {
        $this->complete = $complete;

        return $this;
    }
}
