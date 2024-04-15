<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: LinkRepository::class)]
#[ORM\Table(name: '`link`')]
#[UniqueEntity('uuid')]
#[UniqueEntity('url')]
class Link
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $uuid;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private string $url;

    #[ORM\Column]
    private \DateTimeImmutable $addedAt;

    #[ORM\JoinColumn(nullable: false)]
    private User $addedByUser;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    /**
     * @var array<mixed>
     */
    #[ORM\Column]
    private array $scrapResult;

    /**
     * @param array<mixed> $scrapResult
     */
    public function __construct(string $url, User $addedByUser, array $scrapResult)
    {
        $this->url = $url;
        $this->uuid = Uuid::v4();
        $this->addedByUser = $addedByUser;
        $this->addedAt = new \DateTimeImmutable();
        $this->scrapResult = $scrapResult;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getAddedAt(): \DateTimeImmutable
    {
        return $this->addedAt;
    }

    public function getAddedByUser(): User
    {
        return $this->addedByUser;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @return array<mixed> $scrapResult
     */
    public function getScrapResult(): array
    {
        return $this->scrapResult;
    }
}
