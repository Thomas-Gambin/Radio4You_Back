<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext: ['groups' => ['podcast:read']],
    denormalizationContext: ['groups' => ['podcast:write']]
)]
class Podcast
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['podcast:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private string $title;

    #[ORM\Column(length: 200, unique: true)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private string $slug;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?string $description = null;

    // Cloudinary cover
    #[ORM\Column(nullable: true)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?string $coverPublicId = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?string $coverUrl = null;

    // Video on Cloudinary
    #[ORM\Column(nullable: true)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?string $videoPublicId = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?string $videoUrl = null;

    // Audio stays as external URL (or host on Cloudinary if tu veux plus tard)
    #[ORM\Column(nullable: true)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?string $audioUrl = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?int $durationSec = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(['podcast:read'])]
    private ?\DateTimeImmutable $publishedAt = null;

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

    public function getSlug(): string
    {
        return $this->slug;
    }
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $d): self
    {
        $this->description = $d;
        return $this;
    }

    public function getCoverPublicId(): ?string
    {
        return $this->coverPublicId;
    }
    public function setCoverPublicId(?string $id): self
    {
        $this->coverPublicId = $id;
        return $this;
    }

    public function getCoverUrl(): ?string
    {
        return $this->coverUrl;
    }
    public function setCoverUrl(?string $url): self
    {
        $this->coverUrl = $url;
        return $this;
    }

    public function getVideoPublicId(): ?string
    {
        return $this->videoPublicId;
    }
    public function setVideoPublicId(?string $id): self
    {
        $this->videoPublicId = $id;
        return $this;
    }

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }
    public function setVideoUrl(?string $url): self
    {
        $this->videoUrl = $url;
        return $this;
    }

    public function getAudioUrl(): ?string
    {
        return $this->audioUrl;
    }
    public function setAudioUrl(?string $url): self
    {
        $this->audioUrl = $url;
        return $this;
    }

    public function getDurationSec(): ?int
    {
        return $this->durationSec;
    }
    public function setDurationSec(?int $s): self
    {
        $this->durationSec = $s;
        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }
    public function setPublishedAt(?\DateTimeImmutable $dt): self
    {
        $this->publishedAt = $dt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeImmutable $dt): self
    {
        $this->createdAt = $dt;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(\DateTimeImmutable $dt): self
    {
        $this->updatedAt = $dt;
        return $this;
    }
}
