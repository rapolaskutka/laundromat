<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DormRepository::class)]
#[ApiResource]
class Dorm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'dorm', targetEntity: Machine::class, cascade: ['persist', 'remove'])]
    private Collection $machines;

    #[ORM\ManyToOne(inversedBy: 'admin_dorms')]
    #[ORM\JoinColumn(name: "administrator_id", referencedColumnName: "id", onDelete: "SET NULL")]
    private ?User $administrator = null;

    #[ORM\OneToMany(mappedBy: 'dorm', targetEntity: User::class)]
    private Collection $residents;

    public function __construct()
    {
        $this->machines = new ArrayCollection();
        $this->residents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Machine>
     */
    public function getMachines(): Collection
    {
        return $this->machines;
    }

    public function addMachine(Machine $machine): static
    {
        if (!$this->machines->contains($machine)) {
            $this->machines->add($machine);
            $machine->setDorm($this);
        }

        return $this;
    }

    public function removeMachine(Machine $machine): static
    {
        if ($this->machines->removeElement($machine)) {
            // set the owning side to null (unless already changed)
            if ($machine->getDorm() === $this) {
                $machine->setDorm(null);
            }
        }

        return $this;
    }

    public function getAdministrator(): ?User
    {
        return $this->administrator;
    }

    public function setAdministrator(?User $administrator): static
    {
        $this->administrator = $administrator;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getResidents(): Collection
    {
        return $this->residents;
    }

    public function addResident(User $resident): static
    {
        if (!$this->residents->contains($resident)) {
            $this->residents->add($resident);
            $resident->setDorm($this);
        }

        return $this;
    }

    public function removeResident(User $resident): static
    {
        if ($this->residents->removeElement($resident)) {
            // set the owning side to null (unless already changed)
            if ($resident->getDorm() === $this) {
                $resident->setDorm(null);
            }
        }

        return $this;
    }

    public function __ToString(): string
    {
        return $this->getName();
    }
}
