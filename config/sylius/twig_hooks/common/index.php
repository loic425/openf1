<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $container->extension('sylius_twig_hooks', [
        'hooks' => [
            'sylius_admin.common.index.content' => [
                'grid' => [
                    'template' => 'shared/crud/index/content/grid.html.twig',
                ],
            ],

//            'sylius_admin.common.index.content.grid' => [
//                'no_data_block' => [
//                    'template' => 'shared/crud/index/content/grid/no_results.html.twig',
//                ],
//            ],
        ],
    ]);
};
