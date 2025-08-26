<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['live:read']]),
        new Patch(denormalizationContext: ['groups' => ['live:write']], security: "is_granted('ROLE_ADMIN')")
    ]
)]
class LiveStream
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['live:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['live:read', 'live:write'])]
    private string $streamUrl;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['live:read', 'live:write'])]
    private ?string $backupStreamUrl = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['live:read', 'live:write'])]
    private bool $isLive = true;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['live:read', 'live:write'])]
    private ?string $nowPlayingTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['live:read', 'live:write'])]
    private ?string $nowPlayingArtist = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['live:read'])]
    private ?int $listeners = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
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

    public function getStreamUrl(): string
    {
        return $this->streamUrl;
    }
    public function setStreamUrl(string $u): self
    {
        $this->streamUrl = $u;
        return $this;
    }

    public function getBackupStreamUrl(): ?string
    {
        return $this->backupStreamUrl;
    }
    public function setBackupStreamUrl(?string $u): self
    {
        $this->backupStreamUrl = $u;
        return $this;
    }

    public function isLive(): bool
    {
        return $this->isLive;
    }
    public function setIsLive(bool $v): self
    {
        $this->isLive = $v;
        return $this;
    }

    public function getNowPlayingTitle(): ?string
    {
        return $this->nowPlayingTitle;
    }
    public function setNowPlayingTitle(?string $t): self
    {
        $this->nowPlayingTitle = $t;
        return $this;
    }

    public function getNowPlayingArtist(): ?string
    {
        return $this->nowPlayingArtist;
    }
    public function setNowPlayingArtist(?string $a): self
    {
        $this->nowPlayingArtist = $a;
        return $this;
    }

    public function getListeners(): ?int
    {
        return $this->listeners;
    }
    public function setListeners(?int $n): self
    {
        $this->listeners = $n;
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
