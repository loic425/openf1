<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $container->extension('sylius_twig_hooks', [
        'hooks' => [
            'sylius_admin.session.show.content.header.title_block' => [
                'title' => [
                    'template' => '@SyliusBootstrapAdminUi/shared/crud/show/content/header/title_block/title.html.twig',
                    'configuration' => [
                        'title' => '@=_context.session.id',
                        'icon' => 'ri:user-received-2-line',
                    ],
                ],
            ],
            'sylius_admin.session.show.content' => [
                'body' => [
                    'template' => 'session/show/content/body.html.twig',
                ],
            ],
        ],
    ]);
};
