<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MagicLinkSentConfirmationController extends AbstractController
{
    #[Route('/magic-link/sent-confirmation', name: 'magic_link_sent_confirmation')]
    public function __invoke(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('user_account');
        }

        return $this->render('magic_link/sent_confirmation.html.twig', [
        ]);
    }
}
