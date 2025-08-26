<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext: ['groups' => ['article:read']],
    denormalizationContext: ['groups' => ['article:write']],
    operations: [
        new GetCollection(),            // GET /api/articles
        new Get(),                      // GET /api/articles/{id}
    ]
)]
class Article
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['article:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['article:read', 'article:write'])]
    private string $title;

    #[ORM\Column(type: 'text')]
    #[Groups(['article:read', 'article:write'])]
    private string $content;

    #[ORM\Column(nullable: true)]
    #[Groups(['article:read', 'article:write'])]
    private ?string $coverPublicId = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['article:read', 'article:write'])]
    private ?string $coverUrl = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['article:read'])]
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


    public function getContent(): string
    {
        return $this->content;
    }
    public function setContent(string $content): self
    {
        $this->content = $content;
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
