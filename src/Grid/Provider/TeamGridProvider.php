<?php

namespace App\Grid\Provider;

use App\Model\Team;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Sylius\Component\Grid\Data\DataProviderInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;

final readonly class TeamGridProvider implements DataProviderInterface
{
    public function getData(Grid $grid, Parameters $parameters): PagerFantaInterface
    {
        $teams = iterator_to_array($this->getTeamsPaginator());

        return new Pagerfanta(new ArrayAdapter($teams));
    }

    public function getTeamsPaginator(): iterable
    {
        $teams = [
            ['name' =>'Alfa Romeo', 'color' => 'C92D4B'],
            ['name' =>'AlphaTauri', 'color' => '5E8FAA'],
            ['name' =>'Alpine', 'color' => '2293D1'],
            ['name' =>'Aston Martin', 'color' => '358C75'],
            ['name' =>'Ferrari', 'color' => 'F91536'],
            ['name' =>'Haas F1 Team', 'color' => 'B6BABD'],
            ['name' =>'McLaren', 'color' => 'F58020'],
            ['name' =>'Mercedes', 'color' => '6CD3BF'],
            ['name' =>'Red Bull Racing', 'color' => '3671C6'],
            ['name' =>'Williams', 'color' => '37BEDD'],
            ['name' =>'Estelle Racing', 'color' => null],
            ['name' =>'Loïc F1 Team', 'color' => '37BEDD'],
        ];

        foreach ($teams as $team) {
            yield new Team(
                id: $team['name'],
                name: $team['name'],
                color: $team['color'],
            );
        }
    }
}
