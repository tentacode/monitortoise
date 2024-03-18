<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserAccountController extends AbstractController
{
    #[Route('/my-account', name: 'user_account')]
    public function __invoke(): Response
    {
        return $this->render('account/my_account.html.twig', [
        ]);
    }
}
