<?php

declare(strict_types=1);

namespace App\Tests\Feature\Account\Query;

use App\Feature\Account\Exception\UserNotFoundException;
use App\Feature\Account\Query\GetUserByEmail;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetUserByEmailTest extends KernelTestCase
{
    #[Test]
    public function it_gets_existing_user_with_its_email(): void
    {
        $getUserByEmail = static::getContainer()->get(GetUserByEmail::class);

        $user = $getUserByEmail('gabriel@tentacode.test');

        $this->assertSame($user->getEmail(), 'gabriel@tentacode.test');
    }

    #[Test]
    public function it_throws_an_exception_when_the_email_is_not_valid(): void
    {
        $getUserByEmail = static::getContainer()->get(GetUserByEmail::class);

        $this->expectException(\InvalidArgumentException::class);
        $getUserByEmail('invalid-email');
    }

    #[Test]
    public function it_throws_an_exception_when_the_email_does_not_match_any_user(): void
    {
        $getUserByEmail = static::getContainer()->get(GetUserByEmail::class);

        $this->expectException(UserNotFoundException::class);
        $getUserByEmail('salut@example.test');
    }
}
