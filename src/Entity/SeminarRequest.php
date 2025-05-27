<?php

namespace App\Entity;

use App\Repository\SeminarRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeminarRequestRepository::class)]
class SeminarRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $theme = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTime $requestedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $seminarDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $finalFile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $summary = null;

    #[ORM\ManyToOne(inversedBy: 'seminarRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $requestedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getRequestedAt(): ?\DateTime
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(\DateTime $requestedAt): static
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }

    public function getSeminarDate(): ?\DateTime
    {
        return $this->seminarDate;
    }

    public function setSeminarDate(?\DateTime $seminarDate): static
    {
        $this->seminarDate = $seminarDate;

        return $this;
    }

    public function getFinalFile(): ?string
    {
        return $this->finalFile;
    }

    public function setFinalFile(?string $finalFile): static
    {
        $this->finalFile = $finalFile;

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

    public function getRequestedBy(): ?User
    {
        return $this->requestedBy;
    }

    public function setRequestedBy(?User $requestedBy): static
    {
        $this->requestedBy = $requestedBy;

        return $this;
    }
}
