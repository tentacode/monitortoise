<?php

declare(strict_types=1);

namespace App\Feature\Scraper\DTO;

final readonly class ScrappedUrlResult
{
    /**
     * @param array<string> $keywords
     * @param array<string> $openGraph
     * @param array<string> $twitterCard
     * @param array<string> $rssUrls
     * @param array<mixed>  $contentTextHierarchy
     * @param array<string> $contentImages
     */
    public function __construct(
        public ?string $title,
        public ?string $canonical,
        public ?string $contentType,
        public ?string $description,
        public ?string $image,
        public ?string $author,
        public ?array $keywords,
        public ?array $openGraph,
        public ?array $twitterCard,
        public ?array $rssUrls,
        public ?array $contentTextHierarchy,
        public ?array $contentImages,
    ) {
    }
}
