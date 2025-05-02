<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {

    $container->extension('sylius_twig_hooks', [
        'hooks' => [
            'sylius_admin.team_radio.index.content.header.title_block' => [
                'title' => [
                    'template' => '@SyliusBootstrapAdminUi/shared/crud/common/content/header/title_block/title.html.twig',
                    'configuration' => [
                        'icon' => 'tabler:radio',
                    ],
                ],
            ],
        ],
    ]);
};
