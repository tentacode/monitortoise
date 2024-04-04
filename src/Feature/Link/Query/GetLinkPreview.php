<?php

declare(strict_types=1);

namespace App\Feature\Link\Query;

use App\Feature\Link\DTO\LinkPreview;
use App\Feature\Scraper\DTO\ScrappedUrlResult;
use App\Feature\Scraper\Query\ScrapUrl;

final class GetLinkPreview
{
    public function __construct(
        private ScrapUrl $scrapUrl,
    ) {
    }

    public function __invoke(string $url): LinkPreview
    {
        $scrappedResult = ($this->scrapUrl)($url);

        return new LinkPreview(
            title: $scrappedResult->title,
            description: $scrappedResult->description,
            imageUrl: $this->guessImage($scrappedResult),
        );
    }

    private function guessImage(ScrappedUrlResult $scrappedResult): ?string
    {
        if (! empty($scrappedResult->image)) {
            return $scrappedResult->image;
        }

        if (isset($scrappedResult->openGraph['og:image'])) {
            return $scrappedResult->openGraph['og:image'];
        }

        if (isset($scrappedResult->twitterCard['twitter:image'])) {
            return $scrappedResult->twitterCard['twitter:image'];
        }

        return null;
    }
}
