<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('uuid')]
#[UniqueEntity('email')]
#[UniqueEntity('username')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $uuid;

    #[ORM\Column(length: 255, unique: true)]
    private string $email;

    #[ORM\Column(length: 30, unique: true)]
    private string $username;

    #[ORM\Column]
    private \DateTimeImmutable $registeredAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastSeenAt = null;

    public function __construct(string $email, string $username)
    {
        Assert::email($email);
        Assert::lengthBetween($username, 3, 30);

        $this->email = $email;
        $this->username = $username;
        $this->registeredAt = new \DateTimeImmutable();
        $this->uuid = Uuid::v4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRegisteredAt(): \DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function getLastSeenAt(): ?\DateTimeImmutable
    {
        return $this->lastSeenAt;
    }

    public function refreshLastSeenAt(): void
    {
        $this->lastSeenAt = new \DateTimeImmutable();
    }
}
