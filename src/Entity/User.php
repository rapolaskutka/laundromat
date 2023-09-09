<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    const ADMIN = 'ROLE_ADMIN';
    const USER = 'ROLE_USER';

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'administrator', targetEntity: Dorm::class)]
    private Collection $admin_dorms;

    #[ORM\ManyToOne(inversedBy: 'residents')]
    private ?Dorm $dorm = null;

    public function __construct()
    {
        $this->admin_dorms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = self::USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Dorm>
     */
    public function getDorms(): Collection
    {
        return $this->admin_dorms;
    }

    public function addAdminDorm(Dorm $dorm): static
    {
        if (!$this->admin_dorms->contains($dorm)) {
            $this->admin_dorms->add($dorm);
            $dorm->setAdministrator($this);
        }

        return $this;
    }

    public function removeAdminDorm(Dorm $dorm): static
    {
        if ($this->admin_dorms->removeElement($dorm)) {
            // set the owning side to null (unless already changed)
            if ($dorm->getAdministrator() === $this) {
                $dorm->setAdministrator(null);
            }
        }

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
