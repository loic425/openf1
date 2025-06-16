<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $container->extension('sylius_twig_hooks', [
        'hooks' => [
            'sylius_admin.base#javascripts' => [
                'app' => [
                    'priority' => 200,
                    'template' => 'base/javascripts/app.html.twig',
                ],
                'symfony_ux' => [
                    'enabled' => false,
                ],
            ],
            'sylius_admin.base#stylesheets' => [
                'symfony_ux' => [
                    'enabled' => false,
                ],
            ],
        ],
    ]);
};
