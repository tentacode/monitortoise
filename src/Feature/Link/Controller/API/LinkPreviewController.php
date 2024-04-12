<?php

declare(strict_types=1);

namespace App\Feature\Link\Controller\API;

use App\Feature\Link\Query\GetLinkPreview;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LinkPreviewController extends AbstractController
{
    public function __construct(
        private GetLinkPreview $getLinkPreview,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/link/preview', name: 'api_link_preview', methods: ['GET'], format: 'json')]
    public function __invoke(Request $request): JsonResponse
    {
        $objectNormalizer = new ObjectNormalizer();
        $urlInput = $objectNormalizer->denormalize($request->query->all(), UrlInput::class);

        $constraints = $this->validator->validate($urlInput);
        if (count($constraints) > 0) {
            throw new ValidationFailedException($urlInput, new ConstraintViolationList($constraints));
        }

        $linkPreview = ($this->getLinkPreview)($urlInput->url);

        return new JsonResponse($linkPreview);
    }
}

final class UrlInput
{
    #[Assert\NotBlank]
    #[Assert\Url]
    public string $url;
}
