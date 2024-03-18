<?php

declare(strict_types=1);

namespace App\Feature\Account\Email;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Header\TagHeader;
use Symfony\Component\Mime\Address;

final class SendMagicLinkEmail extends TemplatedEmail
{
    public function __construct(
        User $user,
        string $loginLinkUrl,
    ) {
        parent::__construct();

        $this->to(new Address($user->getEmail(), $user->getUsername()))
            ->subject('Sign in to monitortoise')
            ->htmlTemplate('emails/send_magic_link.html.twig')
            ->textTemplate('emails/send_magic_link.txt.twig')
            ->context([
                'user' => $user,
                'magic_login_link_url' => $loginLinkUrl,
            ]);

        $this->getHeaders()->add(new TagHeader('send_magic_link'));
    }
}
