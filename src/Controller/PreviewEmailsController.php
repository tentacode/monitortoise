<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PreviewEmailsController extends AbstractController
{
    #[Route('/preview-email/magic-link')]
    public function index(): Response
    {
        return $this->render('emails/send_magic_link.html.twig', [
            'magic_login_link_url' => 'http://foo.test',
        ]);
    }
}
