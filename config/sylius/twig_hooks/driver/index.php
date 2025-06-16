<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {

    $container->extension('sylius_twig_hooks', [
        'hooks' => [
            'sylius_admin.driver.index.content.header.title_block' => [
                'title' => [
                    'template' => '@SyliusBootstrapAdminUi/shared/crud/common/content/header/title_block/title.html.twig',
                    'configuration' => [
                        'icon' => 'game-icons:full-motorcycle-helmet',
                    ],
                ],
            ],

            'sylius_admin.driver.index.content.grid' => [
                'data_table' => [
                    'component' => 'sylius_grid_data_table',
                    'props' => [
                        'grid' => '@=_context.grid',
                        'page' => '@=_context.page',
                        'limit' => '@=_context.limit',
                        'criteria' => '@=_context.criteria',
                    ],
                ],
            ],
        ],
    ]);
};
