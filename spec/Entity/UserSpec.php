<?php

declare(strict_types=1);

namespace spec\App\Entity;

use App\Entity\User;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Uid\Uuid;

class UserSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('superman@dc.test', 'caleb');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    public function it_has_all_required_properties()
    {
        $this->getId()->shouldBeNull();
        $this->getEmail()->shouldReturn('superman@dc.test');
        $this->getUsername()->shouldReturn('caleb');
        $this->getUuid()->shouldBeAnInstanceOf(Uuid::class);
        $this->getRegisteredAt()->shouldBeAnInstanceOf(\DateTimeImmutable::class);

        // registration date should be now
        $now = new \DateTimeImmutable();
        $this->getRegisteredAt()->getTimestamp()->shouldBeApproximately($now->getTimestamp(), 1);

        // user has no activity before login
        $this->getLastSeenAt()->shouldBeNull();
    }

    public function it_sets_last_seen_at_when_refreshed()
    {
        $this->refreshLastSeenAt();

        $this->getLastSeenAt()->shouldBeAnInstanceOf(\DateTimeImmutable::class);

        // last seen date should be now
        $now = new \DateTimeImmutable();
        $this->getRegisteredAt()->getTimestamp()->shouldBeApproximately($now->getTimestamp(), 1);
    }
}
