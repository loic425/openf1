<?php

namespace App\Grid;

use App\Grid\Filter\CountryFilter;
use App\Grid\Filter\TeamFilter;
use App\Grid\Provider\DriverApiGridProvider;
use App\Grid\Provider\DriverEmptyGridProvider;
use App\Grid\Provider\DriverFixedGridProvider;
use App\Grid\Provider\DriverRepositoryGridProvider;
use App\Resource\DriverResource;
use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\Action\ShowAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Component\Grid\Attribute\AsGrid;

#[AsGrid(
    resourceClass: DriverResource::class,
    provider: DriverApiGridProvider::class,
    name: 'driver',
)]
final class DriverGrid extends AbstractGrid
{
    public function __invoke(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->setLimits([10, 25])
            ->addFilter(
                Filter::create('country', CountryFilter::class)
                    ->setFormOptions([
                        'alpha3' => true,
                        'autocomplete' => true,
                        'placeholder' => 'Choose a country',
                    ])
                    ->setLabel('app.ui.country')
            )
            ->addFilter(
                Filter::create('teamName', TeamFilter::class)
                    ->setFormOptions([
                        'autocomplete' => true,
                    ])
                    ->setLabel('app.ui.team')
            )
            ->addField(
                TwigField::create('image', 'driver/grid/field/image.html.twig')
            )
            ->addField(
                StringField::create('number'),
            )
            ->addField(
                StringField::create('firstName'),
            )
            ->addField(
                StringField::create('lastName'),
            )
            ->addField(
                StringField::create('countryCode'),
            )
            ->addField(
                StringField::create('teamName')
                    ->setLabel('app.ui.team')
                ,
            )
//            ->addActionGroup(
//                ItemActionGroup::create(
//                    Action::create('team_radios', 'show')
//                        ->setOptions([
//                            'link' => [
//                                'route' => 'app_admin_team_radio_index',
//                                'parameters' => [
//                                    'criteria' => [
//                                        'driver_number' => [
//                                            'value' => 'resource.number',
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ])
//                        ->setLabel('app.ui.show_team_radios')
//                        ->setIcon('tabler:radio'),
//                    ShowAction::create(),
//                )
//            )
        ;
    }
}
