<?php

namespace App\Grid\Provider;

use App\Resource\DriverResource;
use App\Resource\SessionResource;
use App\Resource\TeamRadioResource;
use Pagerfanta\Adapter\FixedAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Sylius\Component\Grid\Data\DataProviderInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;
use Symfony\Component\HttpFoundation\Session\Session;

final readonly class SessionFixedGridProvider implements DataProviderInterface
{
    public function getData(Grid $grid, Parameters $parameters): PagerFantaInterface
    {
        // start with an empty paginator
        return new Pagerfanta(new FixedAdapter(3, $this->getDrivers()));
    }


    private function getDrivers(): iterable
    {
        yield new SessionResource(
            id: 9140,
            year: '2023',
            location: 'Spa-Francorchamps',
            countryCode: 'BEL',
            startsAt: new \DateTimeImmutable('2023-07-29T15:05:00+00:00'),
            endsAt: new \DateTimeImmutable('2023-07-29T15:35:00+00:00'),
        );
    }
}
