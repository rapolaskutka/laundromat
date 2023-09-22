<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\HistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoryRepository::class)]
#[ApiResource]
#[ApiResource(
    uriTemplate: '/dorms/{dormId}/machines/{machineId}/histories/{id}',
    operations: [ new Get() ],
    uriVariables: [
        'dormId' => new Link(toProperty: 'dorm', fromClass: Dorm::class),
        'machineId' => new Link(toProperty: 'machine', fromClass: Machine::class),
        'id' => new Link(fromClass: History::class),
    ]
)]
#[ApiResource(
    uriTemplate: '/dorms/{dormId}/machines/{machineId}/histories',
    operations: [ new GetCollection() ],
    uriVariables: [
        'dormId' => new Link(toProperty: 'dorm', fromClass: Dorm::class),
        'machineId' => new Link(toProperty: 'machine', fromClass: Machine::class),
    ]
)]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'history')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'history')]
    private ?Machine $machine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getMachine(): ?Machine
    {
        return $this->machine;
    }

    public function setMachine(?Machine $machine): static
    {
        $this->machine = $machine;

        return $this;
    }
}
