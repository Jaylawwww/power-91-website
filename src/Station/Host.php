<?php

namespace App\Station;

final readonly class Host
{
    public function __construct(
        public string $name,
        public string $role,
        public string $show,
        public string $bio,
        public string $initials,
        public string $accent,
    ) {
    }
}
