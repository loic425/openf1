<?php

namespace App\Resource;

use App\Grid\DriverGrid;
use App\Grid\PokemonGrid;
use App\Grid\TeamRadioGrid;
use App\Model\Pokemon;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Model\ResourceInterface;

#[AsResource(
    section: 'admin',
    templatesDir: '@SyliusAdminUi/crud',
    routePrefix: '/admin',
    operations: [
        new Index(grid: TeamRadioGrid::class),
    ],
)]
final readonly class TeamRadioResource implements ResourceInterface
{
    public function __construct(
        public \DateTimeImmutable $date,
        public int $driverNumber,
        public string $recordingUrl,
    ) {
    }

    public function getId(): string
    {
        return $this->date->format('c') . '/' . $this->driverNumber;
    }
}
