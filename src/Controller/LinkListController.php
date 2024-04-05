<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LinkListController extends AbstractController
{
    #[Route('/links', name: 'link_list')]
    public function __invoke(): Response
    {
        return $this->render('link/link_list.html.twig', [
        ]);
    }
}
