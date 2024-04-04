<?php

declare(strict_types=1);

namespace App\Feature\Link\DTO;

final class LinkPreview
{
    public function __construct(
        public ?string $title,
        public ?string $description,
        public ?string $imageUrl,
    ) {
    }
}
