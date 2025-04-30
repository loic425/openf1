<?php

namespace App\Grid;

use App\Grid\Filter\CountryFilter;
use App\Grid\Provider\DriverRepositoryGridProvider;
use App\Resource\PokemonResource;
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
            ->setProvider(DriverRepositoryGridProvider::class)
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
        ;
    }

    public function getResourceClass(): string
    {
        return PokemonResource::class;
    }
}
