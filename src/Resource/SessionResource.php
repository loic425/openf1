<?php

namespace App\Resource;

use App\Grid\DriverGrid;
use App\Grid\SessionGrid;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Model\ResourceInterface;

#[AsResource(
    section: 'admin',
    templatesDir: '@SyliusAdminUi/crud',
    routePrefix: '/admin',
    operations: [
        new Index(grid: SessionGrid::class),
    ],
)]
final readonly class SessionResource implements ResourceInterface
{
    public function __construct(
        public int $id,
        public string $year,
        public string $location,
        public string $countryCode,
        public \DateTimeImmutable $startsAt,
        public \DateTimeImmutable $endsAt,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
