<?php

namespace App\Grid\Filter;

use App\Grid\Template\FilterTemplate;
use Sylius\Component\Grid\Attribute\AsFilter;
use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Filtering\FilterInterface;

#[AsFilter(
    formType: TeamFilterType::class,
    template: FilterTemplate::SELECT->value,
)]
final class TeamFilter implements FilterInterface
{
    public function apply(DataSourceInterface $dataSource, string $name, $data, array $options): void
    {
        // TODO: Implement apply() method.
    }
}
