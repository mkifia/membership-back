<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['admin:read']],
    denormalizationContext: ['groups' => ['admin:write']],
)]
class Admin extends User
{
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['admin:read', 'admin:write'])]
    private ?string $job = null;

    #[ORM\Column(length: 255)]
    #[Groups(['admin:read', 'admin:write'])]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'addedBy', targetEntity: Payment::class)]
    private Collection $paymentsAdded;

    #[ORM\OneToMany(mappedBy: 'addedBy', targetEntity: Payment::class)]
    private Collection $paymentsVerified;

    public function __construct()
    {
        $this->paymentsAdded = new ArrayCollection();
        $this->paymentsVerified = new ArrayCollection();
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }
}
