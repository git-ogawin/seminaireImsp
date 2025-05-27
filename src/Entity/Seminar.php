<?php

namespace App\Entity;

use App\Repository\SeminarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeminarRepository::class)]
class Seminar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $fichier = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $summary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file = null;

    #[ORM\ManyToOne(inversedBy: 'seminars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $presenter = null;

    #[ORM\Column(type: 'string', length: 255)]
    private $statut;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $commentaire = null;

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getFichier(): ?string { return $this->fichier; }
    public function setFichier(?string $fichier): self { $this->fichier = $fichier; return $this; }


    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;
        return $this;
    }


    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getPresenter(): ?User
    {
        return $this->presenter;
    }

    public function setPresenter(?User $presenter): static
    {
        $this->presenter = $presenter;

        return $this;
    }
}
