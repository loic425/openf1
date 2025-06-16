<?php

declare(strict_types=1);

use App\Grid\Template\FilterTemplate;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('sylius_grid', [
        'templates' => [
            'action' => [
                'open' => 'shared/grid/action/open.html.twig',
                'show' => 'shared/grid/action/show.html.twig',
            ],
            'filter' => [
                'date' =>  FilterTemplate::DATE->value,
                'select' =>  FilterTemplate::SELECT->value,
                'string' => FilterTemplate::STRING->value,
            ],
        ],
    ]);
};
