<?php

declare(strict_types=1);

namespace App\Feature\Account\Action;

use App\Feature\Account\Email\SendMagicLinkEmail;
use App\Feature\Account\Query\GetUserByEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Webmozart\Assert\Assert;

final class SendMagicLink
{
    public function __construct(
        private GetUserByEmail $getUserByEmail,
        private MailerInterface $mailer,
        private LoginLinkHandlerInterface $loginLinkHandler,
    ) {
    }

    public function __invoke(string $email): void
    {
        Assert::email($email);

        /** throws UserNotFoundException */
        $user = ($this->getUserByEmail)($email);

        $loginLink = $this->loginLinkHandler->createLoginLink($user);
        $loginLinkUrl = $loginLink->getUrl();

        $sendMagicLinkEmail = new SendMagicLinkEmail($user, $loginLinkUrl);

        $this->mailer->send($sendMagicLinkEmail);
    }
}
