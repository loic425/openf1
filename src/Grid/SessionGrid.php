<?php

namespace App\Grid;

use App\Grid\Provider\SessionApiGridProvider;
use App\Grid\Template\FieldTemplate;
use App\Resource\SessionResource;
use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\Action\ShowAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Component\Grid\Attribute\AsGrid;

#[AsGrid(
    resourceClass: SessionResource::class,
    name: 'session',
)]
final class SessionGrid extends AbstractGrid
{
    public function __invoke(GridBuilderInterface $gridBuilder): void
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
                StringField::create('sessionName')
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
            ->addActionGroup(
                ItemActionGroup::create(
                    ShowAction::create(),
                )
            )
        ;
    }
}
