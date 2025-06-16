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
use Webmozart\Assert\Assert;

#[AsLiveComponent(
    name: 'sylius_grid_filter.string',
    template: 'shared/component/grid/filter/string.html.twig',
    route: 'ux_live_component_admin',
)]
final class StringFilterComponent
{
    use DefaultActionTrait;
    use ComponentToolsTrait;
    use ComponentWithFilterTrait;
    use ComponentWithFormTrait;
    use HookableComponentTrait;

    public function __construct(
        private FormFactoryInterface $formFactory,
    ) {
    }

    /** @var array<string, mixed> */
    #[LiveProp(writable: true)]
    public array $initialCriteria;

    #[LiveProp(writable: true)]
    public string|null $value = null;

    #[LiveAction]
    public function onValueChange(): void
    {
        $filter = $this->getFilter();

        $this->emit('criteriaSubmitted', [
            'criteria' => [
                $filter->getName() => [
                    'value' => $this->value,
                ],
            ],
        ]);
    }

    protected function instantiateForm(): FormInterface
    {
        Assert::notNull($this->filter);

        $form = $this->formFactory->createNamed('criteria', CriteriaForm::class, $this->initialCriteria, [
            'filters' => [$this->filter],
        ]);

        $field = $form->get($this->filter->getName());

        if (null === $this->value && $field->has('value')) {
            $fieldValue = $field->get('value')->getData();
            $this->value = is_scalar($fieldValue) ? (string) $fieldValue : null;
        }

        return $field;
    }
}
