<?php

declare(strict_types=1);

namespace App\Twig\Component\Grid;

use Pagerfanta\PagerfantaInterface;
use Sylius\Component\Grid\Parameters;
use Sylius\Component\Grid\Provider\ChainProvider;
use Sylius\Component\Grid\Provider\GridProviderInterface;
use Sylius\Component\Grid\View\GridViewFactoryInterface;
use Sylius\Component\Grid\View\GridViewInterface;
use Sylius\TwigHooks\Twig\Component\HookableComponentTrait;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(
    name: 'sylius_grid_data_table',
    template: 'shared/component/grid/data_table.html.twig',
    route: 'ux_live_component_admin',
)]
final class DataTableComponent
{
    use DefaultActionTrait;
    use ComponentToolsTrait;
    use HookableComponentTrait;

    #[LiveProp(writable: true)]
    public string|null $grid = null;

    #[LiveProp(writable: true)]
    public int $page = 1;

    /** @var array<string, mixed>|null */
    #[LiveProp(writable: true)]
    public array|null $criteria = null;

    /** @var array<string, string>|null */
    #[LiveProp(writable: true)]
    public array|null $sorting = null;

    #[LiveProp(writable: true)]
    public int|null $limit = null;

    #[LiveProp(writable: true)]
    public bool $pushOnBrowserHistory = true;

    #[LiveProp(writable: true)]
    public bool $showGridHeaders = true;

    #[LiveProp(writable: true)]
    public array|null $columns = null;

    public function __construct(
        #[Autowire(service: ChainProvider::class)]
        private readonly GridProviderInterface $gridProvider,
        private readonly GridViewFactoryInterface $gridViewFactory,
    ) {
    }

    public function getResources(): GridViewInterface
    {
        if (null === $this->grid) {
            throw new \RuntimeException('No Grid has been passed to the component.');
        }

        $gridDefinition = $this->gridProvider->get($this->grid);

        $config = [
            'page' => $this->page,
        ];

        if (null !== $this->criteria) {
            $config['criteria'] = $this->criteria;
        }

        if (null !== $this->sorting) {
            $config['sorting'] = $this->sorting;
        }

        if (null !== $this->limit) {
            $config['limit'] = $this->limit;
        }

        $gridView = $this->gridViewFactory->create(
            $gridDefinition,
            new Parameters($config),
        );

        $data = $gridView->getData();

        if ($data instanceof PagerfantaInterface) {
            if (null !== $this->limit) {
                $data->setMaxPerPage($this->limit);
            }

            $data->setCurrentPage($this->page);

            $this->emit('gridLoaded', [
                'nbResults' => $data->getNbResults(),
            ]);
        }

        return $gridView;
    }

    #[LiveAction]
    public function sortBy(#[LiveArg] string $field, #[LiveArg] string $order): void
    {
        $this->sorting = [
            $field => $order,
        ];
    }

    #[LiveAction]
    public function updateLimit(#[LiveArg] int $limit): void
    {
        $this->page = 1;
        $this->limit = $limit;
    }

    #[LiveAction]
    public function changePage(#[LiveArg] int $page): void
    {
        $this->page = $page;
    }

    #[LiveAction]
    public function previousPage(): void
    {
        --$this->page;
    }

    #[LiveAction]
    public function nextPage(): void
    {
        ++$this->page;
    }

    /** @param array<string, mixed> $criteria */
    #[LiveListener('criteriaSubmitted')]
    public function onCriteriaSubmitted(#[LiveArg] array $criteria): void
    {
        $this->criteria = array_merge($this->criteria ?? [], $criteria);
    }
}
