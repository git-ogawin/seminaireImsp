<?php

// src/Entity/NotificationSubscriber.php
namespace App\Entity;

use App\Repository\NotificationSubscriberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationSubscriberRepository::class)]
class NotificationSubscriber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private \DateTimeImmutable $subscribedAt;

    public function __construct()
    {
        $this->subscribedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getEmail(): ?string { return $this->email; }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getSubscribedAt(): \DateTimeImmutable { return $this->subscribedAt; }
}
