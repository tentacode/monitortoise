<?php

declare(strict_types=1);

namespace App\Tests\Console\Action;

use App\Entity\User;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class UserTest extends TestCase
{
    #[Test]
    public function it_has_proper_defaults(): void
    {
        $now = new \DateTimeImmutable();

        $user = new User(
            email: 'foo@bar.test',
            username: 'foo',
        );

        $this->assertInstanceOf(UserInterface::class, $user);

        $this->assertNull($user->getId());

        $this->assertEquals(['ROLE_USER'], $user->getRoles());

        $this->assertInstanceOf(\DateTimeImmutable::class, $user->getRegisteredAt());
        $this->assertEqualsWithDelta(
            $now->getTimestamp(),
            $user->getRegisteredAt()->getTimestamp(),
            1
        );

        $this->assertNull($user->getLastSeenAt());
    }

    #[Test]
    public function it_sets_last_seen_at_when_refreshed(): void
    {
        $now = new \DateTimeImmutable();

        $user = new User(
            email: 'carlos@papayou.fr',
            username: 'carlos',
        );

        $this->assertNull($user->getLastSeenAt());

        $user->refreshLastSeenAt();

        $this->assertInstanceOf(\DateTimeImmutable::class, $user->getLastSeenAt());
        $this->assertEqualsWithDelta(
            $now->getTimestamp(),
            $user->getLastSeenAt()->getTimestamp(),
            1
        );
    }
}
