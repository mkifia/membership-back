<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['payment', 'payment:read']],
    denormalizationContext: ['groups' => ['payment', 'payment:write']],
)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['payment:read', 'payment:write', 'member:read'])]
    private ?float $amount = null;

    #[ORM\Column]
    #[Groups(['payment:read', 'payment:write', 'member:read'])]
    private ?int $year = null;

    #[ORM\Column(length: 3)]
    #[Groups(['payment:read', 'payment:write', 'member:read'])]
    private ?string $currency = null;

    #[ORM\Column(length: 255)]
    #[Groups(['payment:read', 'payment:write', 'member:read'])]
    private ?string $method = null;

    #[ORM\Column]
    #[Groups(['payment:read', 'payment:write'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['payment:read', 'payment:write'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['payment:read', 'payment:write', 'member:read'])]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['payment:read'])]
    private ?Member $member = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    #[ORM\ManyToOne(inversedBy: 'paymentsAdded')]
    private ?Admin $addedBy = null;

    #[ORM\ManyToOne(inversedBy: 'paymentsVerified')]
    private ?Admin $validatedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): static
    {
        $this->method = $method;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getAddedBy(): ?Admin
    {
        return $this->addedBy;
    }

    public function setAddedBy(?Admin $addedBy): static
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    public function getValidatedBy(): ?Admin
    {
        return $this->validatedBy;
    }

    public function setValidatedBy(?Admin $validatedBy): static
    {
        $this->validatedBy = $validatedBy;

        return $this;
    }
}
