<?php

declare(strict_types=1);

namespace App\Tests\Feature\Account\Action;

use App\Feature\Account\Action\SendMagicLink;
use App\Feature\Account\Exception\UserNotFoundException;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Mailer\Test\InteractsWithMailer;

class SendMagicLinkTest extends KernelTestCase
{
    use InteractsWithMailer;

    #[Test]
    public function it_sends_magic_link_to_existing_user(): void
    {
        $sendMagicLink = static::getContainer()->get(SendMagicLink::class);

        /**
         * Most of the testing is done via end to end testing.
         * We just check that the email is sent.
         */
        $sendMagicLink->__invoke('gabriel@tentacode.test');

        $this->mailer()->assertSentEmailCount(1);
        $this->mailer()->assertEmailSentTo('gabriel@tentacode.test', 'Sign in to monitortoise');
    }

    #[Test]
    public function it_should_throw_an_exception_when_the_user_does_not_exist(): void
    {
        $sendMagicLink = static::getContainer()->get(SendMagicLink::class);

        $this->expectException(UserNotFoundException::class);

        try {
            $sendMagicLink('somebody.you.only.knew@example.test');
        } finally {
            $this->mailer()->assertNoEmailSent();
        }
    }

    #[Test]
    public function it_should_throw_an_exception_when_the_email_is_invalid(): void
    {
        $sendMagicLink = static::getContainer()->get(SendMagicLink::class);

        $this->expectException(\InvalidArgumentException::class);
        $sendMagicLink('invalid-email');
    }
}
