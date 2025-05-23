<?php

declare(strict_types=1);

namespace App\Resource;

use App\Grid\TeamGrid;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Model\ResourceInterface;

#[AsResource(
    section: 'admin',
    templatesDir: '@SyliusAdminUi/crud',
    routePrefix: '/admin',
    operations: [
        new Index(grid: TeamGrid::class),
    ],
)]
final readonly class TeamResource implements ResourceInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string|null $color = null,
    ) {
    }

    public function getId(): string
    {
        return $this->name;
    }


}