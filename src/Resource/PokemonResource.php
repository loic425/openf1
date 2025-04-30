<?php

namespace App\Resource;

use App\Grid\PokemonGrid;
use App\Model\Pokemon;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Model\ResourceInterface;

#[AsResource(
    section: 'admin',
    templatesDir: '@SyliusAdminUi/crud',
    routePrefix: '/admin',
    operations: [
        new Index(grid: PokemonGrid::class),
    ],
)]
final readonly class PokemonResource implements ResourceInterface
{
    public function __construct(
        public string $id,
        public int $height,
        public int $weight,
        public string|null $image = null,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public static function fromModel(Pokemon $pokemon): static
    {
        return new self(
            id: $pokemon->name,
            height: $pokemon->height,
            weight: $pokemon->weight,
            image: $pokemon->image,
        );
    }
}
