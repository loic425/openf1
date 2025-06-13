<?php

namespace App\Grid;

use App\Grid\Provider\TeamGridProvider;
use App\Grid\Template\FieldTemplate;
use App\Model\Team;
use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Component\Grid\Attribute\AsGrid;

#[AsGrid(
    resourceClass: Team::class,
    name: 'team',
    buildMethod: 'buildGridForAdmin',
    provider: TeamGridProvider::class
)]
final class TeamGrid extends AbstractGrid
{
    public function buildGridForAdmin(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->addFilter(
                StringFilter::create(name: 'name', type: 'contains')
                    ->setLabel('app.ui.team')
            )
            ->addField(
                StringField::create('name')
            )
            ->addField(
                StringField::create('color')
            )
            ->addField(
                TwigField::create('color', FieldTemplate::COLOR->value)
                    ->setOption('vars', [
                        'th_class' => 'w-1 text-center',
                    ])
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    Action::create('drivers', 'show')
                        ->setOptions([
                            'link' => [
                                'route' => 'app_admin_driver_index',
                                'parameters' => [
                                    'criteria' => [
                                        'teamName' => 'resource.name',
                                    ],
                                ],
                            ],
                        ])
                        ->setLabel('app.ui.show_drivers')
                        ->setIcon('openmoji:motorbike-helmet'),
                    )
                )
        ;
    }
}
