<?php

declare(strict_types=1);

namespace spec\App\Feature\Account\Action;

use App\Entity\User;
use App\Feature\Account\Action\CreateNewUser;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Uid\Uuid;

class CreateNewUserSpec extends ObjectBehavior
{
    public function let(EntityManagerInterface $em)
    {
        $this->beConstructedWith($em);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateNewUser::class);
    }

    public function it_creates_a_new_user(EntityManagerInterface $em)
    {
        // user entity should be saved in the database
        $em->persist(Argument::type(User::class))->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $now = new \DateTimeImmutable();
        $user = $this->__invoke(
            'bruce@batman.test',
            'notbatman',
        );

        $user->shouldBeAnInstanceOf(User::class);
        $user->getEmail()->shouldReturn('bruce@batman.test');
        $user->getUsername()->shouldReturn('notbatman');
        $user->getUuid()->shouldBeAnInstanceOf(Uuid::class);
        $user->getRegisteredAt()->shouldBeAnInstanceOf(\DateTimeImmutable::class);

        // registration date should be now
        $user->getRegisteredAt()->getTimestamp()->shouldBeApproximately($now->getTimestamp(), 1);

        // user has no activity before login
        $user->getLastSeenAt()->shouldBeNull();
    }
}
