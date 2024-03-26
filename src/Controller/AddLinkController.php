<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddLinkController extends AbstractController
{
    #[Route('/add-link', name: 'add_link')]
    public function __invoke(): Response
    {
        return $this->render('link/add_link.html.twig', [
        ]);
    }
}
