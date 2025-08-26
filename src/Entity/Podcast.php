<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(),            // GET /api/articles
        new Get(),                      // GET /api/articles/{id}
    ]
)] // CRUD simple via API Platform
class Podcast
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    // URL complète (ex: https://www.youtube.com/watch?v=XXXX)
    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $videoUrl = null;

    // Optionnels
    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $audioUrl = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $coverUrl = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    #[ORM\PreUpdate]
    public function touch(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    // Getters/Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
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

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }
    public function setVideoUrl(?string $videoUrl): self
    {
        $this->videoUrl = $videoUrl;
        return $this;
    }

    public function getAudioUrl(): ?string
    {
        return $this->audioUrl;
    }
    public function setAudioUrl(?string $audioUrl): self
    {
        $this->audioUrl = $audioUrl;
        return $this;
    }

    public function getCoverUrl(): ?string
    {
        return $this->coverUrl;
    }
    public function setCoverUrl(?string $coverUrl): self
    {
        $this->coverUrl = $coverUrl;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
