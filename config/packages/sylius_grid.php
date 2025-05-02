<?php

declare(strict_types=1);

use App\Hermes\Infrastructure\Sylius\Grid\Filter\ArticleStatusFilter;
use App\Hermes\Infrastructure\Sylius\Grid\Filter\IssueFilter;
use App\Hermes\Infrastructure\Sylius\Grid\Filter\IssueStatusFilter;
use App\Hermes\Infrastructure\Sylius\Grid\Filter\PublicationCategoryFilter;
use App\Hermes\Infrastructure\Sylius\Grid\Filter\ClientFilter;
use App\Hermes\Infrastructure\Sylius\Grid\Filter\PublicationFrequencyFilter;
use App\Hermes\Infrastructure\Sylius\Grid\Filter\SubscriptionStatusFilter;
use App\Hermes\Infrastructure\Sylius\Grid\Filter\TitleFilter;
use App\Hermes\Infrastructure\Sylius\Grid\Filter\PublisherFilter;
use App\Hermes\Infrastructure\Sylius\Grid\Filter\SourceFilter;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $selectFilterTemplate = '@SyliusBootstrapAdminUi/shared/grid/filter/select.html.twig';

    $containerConfigurator->extension('sylius_grid', [
        'templates' => [
            'action' => [
                'open' => 'shared/grid/action/open.html.twig',
            ],
        ],
    ]);
};
