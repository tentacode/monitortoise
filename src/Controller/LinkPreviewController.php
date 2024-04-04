<?php

declare(strict_types=1);

namespace App\Controller;

use App\Feature\Link\Query\GetLinkPreview;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class LinkPreviewController extends AbstractController
{
    public function __construct(
        private GetLinkPreview $getLinkPreview
    ) {
    }

    #[Route('/api/link/preview', name: 'api_link_preview', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $url = $request->query->get('url');
        Assert::notNull($url);
        Assert::string($url);

        $linkPreview = ($this->getLinkPreview)($url);

        return new JsonResponse($linkPreview);
    }
}
