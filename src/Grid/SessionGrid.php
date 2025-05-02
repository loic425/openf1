<?php

namespace App\Grid;

use App\Grid\Provider\SessionApiGridProvider;
use App\Grid\Template\FieldTemplate;
use App\Resource\SessionResource;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Component\Grid\Attribute\AsGrid;

#[AsGrid(resourceClass: SessionResource::class)]
final class SessionGrid extends AbstractGrid
{
    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->setProvider(SessionApiGridProvider::class)
            ->addFilter(
                StringFilter::create(name: 'year', type: 'equal')
                    ->setLabel('app.ui.year')
            )
            ->addField(
                StringField::create('location')
            )
            ->addField(
                StringField::create('year')
            )
            ->addField(
                StringField::create('countryCode')
            )
            ->addField(
                TwigField::create('startsAt', FieldTemplate::DATETIME->value)
                    ->setOption('vars', [
                        'th_class' => 'w-1 text-center',
                    ])
            )
            ->addField(
                TwigField::create('endsAt', FieldTemplate::DATETIME->value)
                    ->setOption('vars', [
                        'th_class' => 'w-1 text-center',
                    ])
            )
        ;
    }
}
