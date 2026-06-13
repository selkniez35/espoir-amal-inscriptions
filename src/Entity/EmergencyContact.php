<?php

namespace App\Entity;

use App\Enum\EmergencyContactTypeEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class EmergencyContact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $firstName;

    #[ORM\Column(length: 100)]
    private string $lastName;

    #[ORM\Column(length: 30)]
    private string $phone;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(enumType: EmergencyContactTypeEnum::class)]
    private EmergencyContactTypeEnum $type;

    #[ORM\ManyToOne(inversedBy: 'emergencyContacts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Child $child = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getType(): EmergencyContactTypeEnum
    {
        return $this->type;
    }

    public function setType(EmergencyContactTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getChild(): ?Child
    {
        return $this->child;
    }

    public function setChild(?Child $child): self
    {
        $this->child = $child;

        return $this;
    }

}
