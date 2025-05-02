<?php

namespace App\Grid\Provider;

use App\Resource\DriverResource;
use App\Resource\TeamRadioResource;
use Pagerfanta\Adapter\FixedAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Sylius\Component\Grid\Data\DataProviderInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;

final readonly class TeamRadioFixedGridProvider implements DataProviderInterface
{
    public function getData(Grid $grid, Parameters $parameters): PagerFantaInterface
    {
        // start with an empty paginator
        return new Pagerfanta(new FixedAdapter(3, $this->getDrivers()));
    }


    private function getDrivers(): iterable
    {
        yield new TeamRadioResource(date: new \DateTimeImmutable('2023-09-15T09:40:43.005000'), driverNumber: 11, recordingUrl: 'https://livetiming.formula1.com/static/2023/2023-09-17_Singapore_Grand_Prix/2023-09-15_Practice_1/TeamRadio/SERPER01_11_20230915_104008.mp3');
    }
}
