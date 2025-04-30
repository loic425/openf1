<?php

namespace App\Grid\Provider;

use App\Resource\DriverResource;
use Pagerfanta\Adapter\FixedAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Sylius\Component\Grid\Data\DataProviderInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;

final readonly class DriverFixedGridProvider implements DataProviderInterface
{
    public function getData(Grid $grid, Parameters $parameters): PagerFantaInterface
    {
        // start with an empty paginator
        return new Pagerfanta(new FixedAdapter(3, $this->getDrivers()));
    }


    private function getDrivers(): iterable
    {
        yield new DriverResource(number: 1, firstName: 'Max', lastName: 'Verstappen', countryCode: 'NED', teamName: 'Red Bull Racing', image: 'https://www.formula1.com/content/dam/fom-website/drivers/M/MAXVER01_Max_Verstappen/maxver01.png.transform/1col/image.png');
        yield new DriverResource(number: 2, firstName: 'Logan', lastName: 'Sargeant', countryCode: 'USA', teamName: 'Williams', image: 'https://www.formula1.com/content/dam/fom-website/drivers/L/LOGSAR01_Logan_Sargeant/logsar01.png.transform/1col/image.png');
        yield new DriverResource(number: 4, firstName: 'Lando', lastName: 'Norris', countryCode: 'GBR', teamName: 'McLaren', image: 'https://www.formula1.com/content/dam/fom-website/drivers/L/LANNOR01_Lando_Norris/lannor01.png.transform/1col/image.png');
        yield new DriverResource(number: 44, firstName: 'Lewis', lastName: 'Hamilton', countryCode: 'GBR', teamName: 'Mercedes', image: 'https://www.formula1.com/content/dam/fom-website/drivers/L/LEWHAM01_Lewis_Hamilton/lewham01.png.transform/1col/image.png');
    }
}
