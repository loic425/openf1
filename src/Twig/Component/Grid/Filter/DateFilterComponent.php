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
use Symfony\UX\TwigComponent\Attribute\PostMount;

#[AsLiveComponent(
    name: 'sylius_grid_filter.date',
    template: 'shared/component/grid/filter/date.html.twig',
    route: 'ux_live_component_admin',
)]
final class DateFilterComponent
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
    public string|null $fromDate = null;

    #[LiveProp(writable: true)]
    public string|null $fromTime = null;

    #[LiveProp(writable: true)]
    public string|null $toDate = null;

    #[LiveProp(writable: true)]
    public string|null $toTime = null;

    public function __construct(
        private FormFactoryInterface $formFactory,
    ) {
    }

    #[LiveAction]
    public function onDateChange(): void
    {
        $filter = $this->getFilter();

        $this->emit('criteriaSubmitted', [
            'criteria' => [
                $filter->getName() => [
                    'from' => [
                        'date' => $this->fromDate,
                        'time' => $this->fromTime,
                    ],
                    'to' => [
                        'date' => $this->toDate,
                        'time' => $this->toTime,
                    ],
                ],
            ],
        ]);
    }

    #[PostMount(priority: -10)]
    public function initFilterValues(): void
    {
        $fieldForm = $this->getForm();

        $this->fromDate = $fieldForm->get('from')->getData()?->format('Y-m-d');
        $this->fromTime = $fieldForm->get('from')->getData()?->format('H:i');
        $this->toDate = $fieldForm->get('to')->getData()?->format('Y-m-d');
        $this->toTime = $fieldForm->get('to')->getData()?->format('H:i');
    }

    protected function instantiateForm(): FormInterface
    {
        $filter = $this->getFilter();

        $criteria = $this->initialCriteria;

        $form = $this->formFactory->createNamed('criteria', CriteriaForm::class, null, [
            'filters' => [$filter],
        ]);

        $field = $form->get($filter->getName());

        // Clone the form to avoid submitting it twice (submit is not idempotent).
        $clone = clone $form;
        $clone->submit($criteria);

        $form->setData($clone->getData());

        return $field;
    }
}
