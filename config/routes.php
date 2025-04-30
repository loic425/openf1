<?php

declare(strict_types=1);

use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->add('index', '/')
        ->controller(RedirectController::class)
        ->defaults([
            'route' => 'sylius_admin_ui_dashboard',
        ]);

    $routingConfigurator->import([
        'path' => '../src/Controller/',
        'namespace' => 'App\Controller',
    ], 'attribute');
};
