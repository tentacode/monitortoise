<?php

declare(strict_types=1);

namespace App\Tests\Feature\Account\Action;

use App\Entity\User;
use App\Feature\Account\Action\CreateNewUser;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\UuidV4;

class CreateNewUserTest extends KernelTestCase
{
    #[Test]
    public function it_create_a_non_existing_user(): void
    {
        $createNewUser = static::getContainer()->get(CreateNewUser::class);

        $now = new \DateTimeImmutable();
        $user = $createNewUser(
            email: 'batman@dc.test',
            username: 'brucewayne',
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertIsNumeric($user->getId());
        $this->assertInstanceOf(UuidV4::class, $user->getUuid());

        $this->assertInstanceOf(\DateTimeImmutable::class, $user->getRegisteredAt());
        $this->assertEqualsWithDelta(
            $now->getTimestamp(),
            $user->getRegisteredAt()->getTimestamp(),
            1
        );

        // user has no activity before login
        $this->assertNull($user->getLastSeenAt());
    }

    #[Test]
    public function it_cannot_create_a_user_with_an_already_existing_email(): void
    {
        $createNewUser = static::getContainer()->get(CreateNewUser::class);

        $this->expectException(UniqueConstraintViolationException::class);
        $this->expectExceptionMessage('Key (email)=(gabriel@tentacode.test) already exists.');

        $user = $createNewUser(
            email: 'gabriel@tentacode.test',
            username: 'not_taken',
        );
    }

    #[Test]
    public function it_cannot_create_a_user_with_an_already_existing_username(): void
    {
        $createNewUser = static::getContainer()->get(CreateNewUser::class);

        $this->expectException(UniqueConstraintViolationException::class);
        $this->expectExceptionMessage('Key (username)=(tentacode) already exists.');

        $user = $createNewUser(
            email: 'not_taken@tentacode.test',
            username: 'tentacode',
        );
    }

    // it cannot create a user with an invalid email
    // it cannot create a user with an invalid username
}
