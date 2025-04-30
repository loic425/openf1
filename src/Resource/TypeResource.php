<?php

namespace App\Resource;

use App\Grid\PokemonGrid;
use App\Grid\TypeGrid;
use App\Model\Type;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Model\ResourceInterface;

#[AsResource(
    section: 'admin',
    templatesDir: '@SyliusAdminUi/crud',
    routePrefix: '/admin',
    operations: [
        new Index(grid: TypeGrid::class),
    ],
)]
final readonly class TypeResource implements ResourceInterface
{
    public function __construct(
        public string $id,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public static function fromModel(Type $type): static
    {
        return new self(
            id: $type->name,
        );
    }
}
