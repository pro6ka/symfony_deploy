<?php

namespace App\Entity;

use App\Repository\MpollDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MpollDetailRepository::class)
 * @ORM\Table(name="mpolls_quotas",
 *     indexes={
@ORM\Index(name="mpolls_quotas__mpoll_id__idx", columns={"mpoll_id"}),
@ORM\Index(name="mpolls_quotas__quota_id__idx", columns={"quota_id"})
 *     }
 *     )
 */
class MpollDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Mpoll::class, inversedBy="id")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="mpoll_id", referencedColumnName="id")
     *     })
     */
    private $mpolls;

    /**
     * @ORM\ManyToOne(targetEntity=Quota::class, inversedBy="id")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="quota_id", referencedColumnName="id")
     *     })
     */
    private $quotas;

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
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $sendOrder;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $clicks;

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
    private $completes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMpolls(): ?Mpoll
    {
        return $this->mpolls;
    }

    public function setMpolls(?Mpoll $mpolls): self
    {
        $this->mpolls = $mpolls;

        return $this;
    }

    public function getQuotas(): ?Quota
    {
        return $this->quotas;
    }

    public function setQuotas(?Quota $quotas): self
    {
        $this->quotas = $quotas;

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

    public function setSendOrder(?string $sendOrder): self
    {
        $this->sendOrder = $sendOrder;

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

    public function getPrescreener(): ?string
    {
        return $this->prescreener;
    }

    public function setPrescreener(string $prescreener): self
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

    public function getCompletes(): ?int
    {
        return $this->completes;
    }

    public function setCompletes(?int $completes): self
    {
        $this->completes = $completes;

        return $this;
    }
}
