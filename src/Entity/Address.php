<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['address:read']],
    denormalizationContext: ['groups' => ['address:write']],
)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address:read', 'address:write', 'admin:read', 'admin:write', 'member:read', 'member:write'])]
    private ?string $street = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['address:read', 'address:write', 'admin:read', 'admin:write', 'member:read', 'member:write'])]
    private ?string $suffix = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address:read', 'address:write', 'admin:read', 'admin:write', 'member:read', 'member:write'])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address:read', 'address:write', 'admin:read', 'admin:write', 'member:read', 'member:write'])]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['address:read', 'address:write', 'admin:read', 'admin:write', 'member:read', 'member:write'])]
    private ?string $state = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address:read', 'address:write', 'admin:read', 'admin:write', 'member:read', 'member:write'])]
    private ?string $country = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(mappedBy: 'address', targetEntity: User::class)]
    #[Groups(['address:read'])]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getSuffix(): ?string
    {
        return $this->suffix;
    }

    public function setSuffix(?string $suffix): static
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setAddress($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAddress() === $this) {
                $user->setAddress(null);
            }
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getStreet() . ' ' . $this->getSuffix() . ', ' .
            $this->getCity() . ', ' . $this->getState() . ' ' . $this->getPostalCode() . ', ' . $this->getCountry();
    }
}
