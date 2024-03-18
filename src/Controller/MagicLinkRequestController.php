<?php

declare(strict_types=1);

namespace App\Controller;

use App\Feature\Account\Action\SendMagicLink;
use App\Feature\Account\Exception\UserNotFoundException;
use App\Form\MagicLinkRequestFormModel;
use App\Form\MagicLinkRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class MagicLinkRequestController extends AbstractController
{
    public function __construct(
        private SendMagicLink $sendMagicLink
    ) {
    }

    #[Route('/magic-link/request', name: 'login')]
    public function __invoke(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('user_account');
        }

        $magicLinkRequestForm = $this->createForm(MagicLinkRequestType::class);
        $magicLinkRequestForm->handleRequest($request);

        if ($magicLinkRequestForm->isSubmitted() && $magicLinkRequestForm->isValid()) {
            $formModel = $magicLinkRequestForm->getData();
            Assert::isInstanceOf($formModel, MagicLinkRequestFormModel::class);

            try {
                ($this->sendMagicLink)($formModel->email);
            } catch (UserNotFoundException $e) {
                // if no user is found,
                // we don't want to leak that information
                // but we still log the error
            }

            return $this->redirectToRoute('magic_link_sent_confirmation');
        }

        return $this->render('magic_link/request.html.twig', [
            'magicLinkRequestForm' => $magicLinkRequestForm->createView(),
        ]);
    }
}
