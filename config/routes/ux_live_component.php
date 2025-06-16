<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import('@LiveComponentBundle/config/routes.php')
        ->prefix('/_components')
    ;

    $routingConfigurator->add('ux_live_component_admin', '/admin/_components/{_live_component}/{_live_action}')
        ->defaults([
            '_live_action' => 'get',
        ])
    ;
};
