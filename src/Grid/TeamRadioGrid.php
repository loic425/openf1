<?php

namespace App\Grid;

use App\Grid\Provider\TeamRadioApiGridProvider;
use App\Grid\Template\FieldTemplate;
use App\Resource\TeamRadioResource;
use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;
use Sylius\Component\Grid\Attribute\AsGrid;

#[AsGrid(name: 'team_radio')]
final class TeamRadioGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->setProvider(TeamRadioApiGridProvider::class)
            ->addFilter(
                StringFilter::create(name: 'driver_number', type: 'equal')
                    ->setLabel('app.ui.driver_number')
            )
            ->addField(
                StringField::create('driverNumber'),
            )
            ->addField(
                TwigField::create('date', FieldTemplate::DATETIME->value)
                    ->setOption('vars', [
                        'th_class' => 'w-1 text-center',
                    ])
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    Action::create('listen', 'show')
                        ->setLabel('app.ui.listen')
                        ->setIcon('subway:sound')
                        ->setOptions([
                            'link' => [
                                'target' => '_blank',
                                'url' => 'resource.recordingUrl',
                            ],
                        ]),
                )
            )
        ;
    }

    public function getResourceClass(): string
    {
        return TeamRadioResource::class;
    }
}
