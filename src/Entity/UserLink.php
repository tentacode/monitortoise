<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserLinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserLinkRepository::class)]
class UserLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $addedBy;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Link $link;

    #[ORM\Column]
    private ?\DateTimeImmutable $readAt = null;

    public function __construct(Link $link, User $addedBy)
    {
        $this->addedBy = $addedBy;
        $this->link = $link;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddedBy(): ?User
    {
        return $this->addedBy;
    }

    public function getLink(): ?Link
    {
        return $this->link;
    }

    public function getReadAt(): ?\DateTimeImmutable
    {
        return $this->readAt;
    }
}
