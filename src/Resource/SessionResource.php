<?php

namespace App\Resource;

use App\Grid\SessionGrid;
use App\State\SessionItemProvider;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Metadata\Show;
use Sylius\Resource\Model\ResourceInterface;

#[AsResource(
    section: 'admin',
    templatesDir: '@SyliusAdminUi/crud',
    routePrefix: '/admin',
    operations: [
        new Index(grid: SessionGrid::class),
        new Show(provider: SessionItemProvider::class),
    ],
)]
final readonly class SessionResource implements ResourceInterface
{
    public function __construct(
        public int $id,
        public string $year,
        public string $location,
        public string $countryCode,
        public string $sessionName,
        public string $circuitShortName,
        public \DateTimeImmutable $startsAt,
        public \DateTimeImmutable $endsAt,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
