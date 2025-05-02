<?php

namespace App\Grid;

use App\Grid\Filter\CountryFilter;
use App\Grid\Provider\DriverEmptyGridProvider;
use App\Grid\Provider\DriverFixedGridProvider;
use App\Grid\Provider\DriverRepositoryGridProvider;
use App\Resource\DriverResource;
use App\Resource\PokemonResource;
use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;
use Sylius\Component\Grid\Attribute\AsGrid;

#[AsGrid]
final class DriverGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->setProvider(DriverFixedGridProvider::class)
            ->addFilter(
                Filter::create('country', CountryFilter::class)
                    ->setFormOptions([
                        'alpha3' => true,
                        'autocomplete' => true,
                    ])
                    ->setLabel('app.ui.country')
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
                StringField::create('teamName'),
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    Action::create('team_radios', 'show')
                        ->setOptions([
                            'link' => [
                                'route' => 'app_admin_team_radio_index',
                                'parameters' => [
                                    'criteria' => [
                                        'driver_number' => [
                                            'value' => 'resource.number',
                                        ],
                                    ],
                                ],
                            ],
                        ])
                        ->setLabel('app.ui.show_team_radios')
                        ->setIcon('tabler:radio'),
                )
            )
        ;
    }

    public function getResourceClass(): string
    {
        return DriverResource::class;
    }
}
