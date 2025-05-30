<?php

declare(strict_types=1);

namespace App\Model;
final readonly class Team
{
    public function __construct(
        public string $id,
        public string $name,
        public string|null $color = null,
    ) {
    }
}