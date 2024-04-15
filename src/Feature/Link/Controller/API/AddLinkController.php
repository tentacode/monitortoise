<?php

declare(strict_types=1);

namespace App\Feature\Link\Controller\API;

use App\Feature\Link\Action\AddUserLink;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddLinkController extends AbstractController
{
    public function __construct(
        private ValidatorInterface $validator,
        private AddUserLink $addUserLink,
    ) {
    }

    #[Route('/api/link', name: 'api_add_link', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $objectNormalizer = new ObjectNormalizer();
        $linkInput = $objectNormalizer->denormalize($request->getPayload()->all(), LinkInput::class);

        $constraints = $this->validator->validate($linkInput);
        if (count($constraints) > 0) {
            throw new ValidationFailedException($linkInput, new ConstraintViolationList($constraints));
        }

        ($this->addUserLink)();

        return new JsonResponse([
            'url' => $linkInput->url,
            'isRead' => $linkInput->isRead,
        ], JsonResponse::HTTP_CREATED);
    }
}

final class LinkInput
{
    #[Assert\NotBlank]
    #[Assert\Url]
    public string $url;

    #[Assert\NotNull]
    #[Assert\Type('bool')]
    public mixed $isRead;
}
