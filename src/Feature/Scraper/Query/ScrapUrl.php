<?php

declare(strict_types=1);

namespace App\Feature\Scraper\Query;

use App\Feature\Scraper\DTO\ScrappedUrlResult;
use Spekulatius\PHPScraper\PHPScraper;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class ScrapUrl
{
    public function __construct(
        private PHPScraper $scraper,
        private CacheInterface $scrappedLinksCache,
    ) {
        $this->scraper->setConfig([
            'agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36',
        ]);
    }

    public function __invoke(string $url): ScrappedUrlResult
    {
        $cacheKey = hash('sha256', $url);

        $scrappedResult = $this->scrappedLinksCache->get($cacheKey, function (ItemInterface $item) use ($url) {
            $item->expiresAfter(60 * 5); // 5 minutes

            $this->scraper->go($url);

            return new ScrappedUrlResult(
                title: $this->scraper->title,
                canonical: $this->scraper->canonical,
                contentType: $this->scraper->contentType,
                description: $this->scraper->description,
                image: $this->scraper->image,
                author: $this->scraper->author,
                keywords: $this->scraper->keywords,
                openGraph: $this->scraper->openGraph,
                twitterCard: $this->scraper->twitterCard,
                rssUrls: $this->scraper->rssUrls,
                contentTextHierarchy: $this->scraper->outlineWithParagraphs,
                contentImages: $this->scraper->images
            );
        });

        return $scrappedResult;
    }
}
