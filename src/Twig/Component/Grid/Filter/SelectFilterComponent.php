<?php

declare(strict_types=1);

namespace App\Twig\Component\Grid\Filter;

use App\Twig\Component\Grid\Form\CriteriaForm;
use Sylius\TwigHooks\Twig\Component\HookableComponentTrait;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(
    name: 'sylius_grid_filter.select',
    template: 'shared/component/grid/filter/select.html.twig',
    route: 'ux_live_component_admin',
)]
final class SelectFilterComponent
{
    use DefaultActionTrait;
    use ComponentToolsTrait;
    use ComponentWithFilterTrait;
    use ComponentWithFormTrait;
    use HookableComponentTrait;

    /** @var array<string, mixed> */
    #[LiveProp(writable: true)]
    public array $initialCriteria;

    #[LiveProp(writable: true)]
    public string|null $selectedValue = null;

    public function __construct(
        private FormFactoryInterface $formFactory,
    ) {
    }

    #[LiveAction]
    public function onValueChange(): void
    {
        $filter = $this->getFilter();

        $this->emit('criteriaSubmitted', [
            'criteria' => [
                $filter->getName() => $this->selectedValue,
            ],
        ]);
    }

    protected function instantiateForm(): FormInterface
    {
        $filter = $this->getFilter();

        $criteria = $this->initialCriteria;
        $criteriaName = $filter->getName();

        $form = $this->formFactory->createNamed('criteria', CriteriaForm::class, [], [
            'filters' => [$filter],
        ]);

        $field = $form->get($filter->getName());

        $this->selectedValue = $criteria[$criteriaName] ?? null;

        // Clone the form to avoid submitting it twice (submit is not idempotent).
        $clone = clone $form;
        $clone->submit($criteria);

        $form->setData($clone->getData());

        return $field;
    }
}
