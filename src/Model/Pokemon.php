<?php

namespace App\Model;

final readonly class Pokemon
{
    public function __construct(
        public string $name,
        public int $height,
        public int $weight,
        public string|null $image = null,
    ) {
    }
}
