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

    #[ORM\OneToOne(targetEntity: EmergencyContact::class, cascade: ['persist', 'remove'])]
    private ?EmergencyContact $emergencyContact = null;

    #[ORM\OneToOne(targetEntity: EmergencyContact::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?EmergencyContact $secondaryEmergencyContact = null;

    #[ORM\OneToOne(targetEntity: Doctor::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Doctor $doctor = null;

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

    public function getEmergencyContact(): ?EmergencyContact
    {
        return $this->emergencyContact;
    }

    public function setEmergencyContact(?EmergencyContact $emergencyContact): void
    {
        $this->emergencyContact = $emergencyContact;
    }

    public function getSecondaryEmergencyContact(): ?EmergencyContact
    {
        return $this->secondaryEmergencyContact;
    }

    public function setSecondaryEmergencyContact(?EmergencyContact $secondaryEmergencyContact): void
    {
        $this->secondaryEmergencyContact = $secondaryEmergencyContact;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): void
    {
        $this->doctor = $doctor;
    }


}
