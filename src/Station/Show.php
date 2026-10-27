<?php

namespace App\Station;

final readonly class Show
{
    public function __construct(
        public string $title,
        public string $tagline,
        public string $description,
        public string $hosts,
        public string $when,
    ) {
    }
}
