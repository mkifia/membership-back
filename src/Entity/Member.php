<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['member:read']],
    denormalizationContext: ['groups' => ['member:write']],
)]
class Member extends User
{
    #[ORM\ManyToOne(inversedBy: 'members')]
    #[Groups(['member:read'])]
    private ?Team $team = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Payment::class, orphanRemoval: true)]
    #[Groups(['member:read'])]
    private Collection $payments;

    #[ORM\Column(nullable: true)]
    private ?bool $isForeign = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isMinor = null;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setMember($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getMember() === $this) {
                $payment->setMember(null);
            }
        }

        return $this;
    }

    public function isIsForeign(): ?bool
    {
        return $this->isForeign;
    }

    public function setIsForeign(?bool $isForeign): static
    {
        $this->isForeign = $isForeign;

        return $this;
    }

    public function isIsMinor(): ?bool
    {
        return $this->isMinor;
    }

    public function setIsMinor(?bool $isMinor): static
    {
        $this->isMinor = $isMinor;

        return $this;
    }
}
