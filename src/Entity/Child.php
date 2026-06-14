<?php

namespace App\Entity;

use App\Repository\ChildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChildRepository::class)]
class Child
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    private ?string $lastName = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $level = null;

    #[ORM\ManyToOne(inversedBy: 'children')]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: EmergencyContact::class, mappedBy: 'child', cascade: ['persist', 'remove'])]
    private Collection $emergencyContacts;

    public function __construct()
    {
        $this->emergencyContacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): static
    {
        $this->level = $level;
        return $this;
    }

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function getEmergencyContacts(): Collection
    {
        return $this->emergencyContacts;
    }

    public function setEmergencyContacts(Collection $emergencyContacts): void
    {
        $this->emergencyContacts = $emergencyContacts;
    }

    public function addEmergencyContact(EmergencyContact $contact): self
    {
        if (!$this->emergencyContacts->contains($contact)) {
            $this->emergencyContacts->add($contact);
            $contact->setChild($this);
        }

        return $this;
    }

    public function removeEmergencyContact(EmergencyContact $contact): self
    {
        if ($this->emergencyContacts->removeElement($contact)) {
            if ($contact->getChild() === $this) {
                $contact->setChild(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

}
