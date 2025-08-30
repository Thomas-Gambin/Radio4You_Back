<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(), // GET /api/podcasts
        new Get(), // GET /api/podcasts/{id}
    ],
    normalizationContext: ['groups' => ['podcast:read']],
    denormalizationContext: ['groups' => ['podcast:write']]
)]
class Podcast
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['podcast:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Groups(['podcast:read', 'podcast:write'])]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?string $description = null;

    #[ORM\Column(length: 1024, nullable: true)]
    #[Assert\Length(max: 1024)]
    #[Assert\Url(protocols: ['http', 'https'])]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?string $videoUrl = null;

    #[ORM\Column(length: 1024, nullable: true)]
    #[Assert\Length(max: 1024)]
    #[Groups(['podcast:read'])]
    private ?string $videoPath = null;

    #[ORM\Column(length: 1024, nullable: true)]
    #[Assert\Length(max: 1024)]
    #[Assert\Url(protocols: ['http', 'https'])]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?string $audioUrl = null;

    #[ORM\Column(length: 1024, nullable: true)]
    #[Assert\Length(max: 1024)]
    #[Groups(['podcast:read', 'podcast:write'])]
    private ?string $coverUrl = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['podcast:read'])]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['podcast:read'])]
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

    #[Assert\Callback]
    public function validateEitherVideo(ExecutionContextInterface $context): void
    {
        if (!$this->videoUrl && !$this->videoPath) {
            $context->buildViolation('Fournis une URL YouTube ou téléverse une vidéo.')
                ->atPath('videoUrl')
                ->addViolation();
        }
    }

    // Getters / Setters
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

    public function getVideoPath(): ?string
    {
        return $this->videoPath;
    }
    public function setVideoPath(?string $videoPath): self
    {
        $this->videoPath = $videoPath;
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
