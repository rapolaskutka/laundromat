<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MachineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MachineRepository::class)]
#[ApiResource]
class Machine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastMaintenance = null;

    #[ORM\ManyToOne(inversedBy: 'machines')]
    private ?Dorm $dorm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getLastMaintenance(): ?\DateTimeInterface
    {
        return $this->lastMaintenance;
    }

    public function setLastMaintenance(?\DateTimeInterface $lastMaintenance): static
    {
        $this->lastMaintenance = $lastMaintenance;

        return $this;
    }

    public function getDorm(): ?Dorm
    {
        return $this->dorm;
    }

    public function setDorm(?Dorm $dorm): static
    {
        $this->dorm = $dorm;

        return $this;
    }
}
