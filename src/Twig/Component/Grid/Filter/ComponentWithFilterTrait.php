<?php

declare(strict_types=1);

namespace App\Twig\Component\Grid\Filter;

use Sylius\Component\Grid\Definition\Filter;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Webmozart\Assert\Assert;

trait ComponentWithFilterTrait
{
    #[LiveProp(writable: true, hydrateWith: 'hydrateFilter', dehydrateWith: 'dehydrateFilter')]
    public Filter|null $filter = null;

    public function getFilter(): Filter
    {
        Assert::notNull($this->filter);

        return $this->filter;
    }

    public function dehydrateFilter(Filter $filter): array
    {
        return [
            'name' => $filter->getName(),
            'type' => $filter->getType(),
            'label' => $filter->getLabel(),
            'enabled' => $filter->isEnabled(),
            'options' => $filter->getOptions(),
            'formOptions' => $filter->getFormOptions(),
            'position' => $filter->getPosition(),
        ];
    }

    public function hydrateFilter(array|null $filterData = null): Filter|null
    {
        if (null === $filterData) {
            return null;
        }

        $filter = Filter::fromNameAndType(
            $filterData['name'],
            $filterData['type']
        );

        $filter->setLabel($filterData['label']);
        $filter->setEnabled($filterData['enabled']);
        $filter->setOptions($filterData['options'] ?? []);
        $filter->setFormOptions($filterData['formOptions']);
        $filter->setPosition($filterData['position']);

        return $filter;
    }
}
