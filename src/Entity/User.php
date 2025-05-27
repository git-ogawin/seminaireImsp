<?php

namespace App\Entity;

use App\Entity\Role;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    private ?string $lastName = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];


    #[ORM\Column(length: 50, nullable: true)]
    private ?string $roleType = null;

    /**
     * @var Collection<int, SeminarRequest>
     */

    #[ORM\OneToMany(targetEntity: SeminarRequest::class, mappedBy: 'requestedBy')]
    private Collection $seminarRequests;

    
    /**
     * @var Collection<int, Seminar>
     */
    #[ORM\OneToMany(targetEntity: Seminar::class, mappedBy: 'presenter')]
    private Collection $seminars;

    #[ORM\Column]
    private bool $isVerified = false;

    public function __construct()
    {
        $this->seminarRequests = new ArrayCollection();
        $this->seminars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER'; // toujours présent
        return array_unique($roles);
    }


    public function getFullName(): string
    {
        return $this->firstName.' '.$this->lastName;
    }

  public function setRoles(array $roles): self
{
    $this->roles = $roles;
    return $this;
}

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
{
    // Cette méthode est utilisée pour effacer les données sensibles de l'utilisateur, comme le mot de passe en clair.
    // Si tu ne stockes rien de sensible temporairement, laisse vide.
}


    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getRoleType(): ?string
    {
        return $this->roleType;
    }

    public function setRoleType(?string $roleType): self
    {
        $this->roleType = $roleType;
        return $this;
    }

    /**
     * @return Collection<int, SeminarRequest>
     */
    public function getSeminarRequests(): Collection
    {
        return $this->seminarRequests;
    }

    public function addSeminarRequest(SeminarRequest $seminarRequest): static
    {
        if (!$this->seminarRequests->contains($seminarRequest)) {
            $this->seminarRequests->add($seminarRequest);
            $seminarRequest->setRequestedBy($this);
        }

        return $this;
    }

    public function removeSeminarRequest(SeminarRequest $seminarRequest): static
    {
        if ($this->seminarRequests->removeElement($seminarRequest)) {
            // set the owning side to null (unless already changed)
            if ($seminarRequest->getRequestedBy() === $this) {
                $seminarRequest->setRequestedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Seminar>
     */
    public function getSeminars(): Collection
    {
        return $this->seminars;
    }

    public function addSeminar(Seminar $seminar): static
    {
        if (!$this->seminars->contains($seminar)) {
            $this->seminars->add($seminar);
            $seminar->setPresenter($this);
        }

        return $this;
    }

    public function removeSeminar(Seminar $seminar): static
    {
        if ($this->seminars->removeElement($seminar)) {
            // set the owning side to null (unless already changed)
            if ($seminar->getPresenter() === $this) {
                $seminar->setPresenter(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

}
