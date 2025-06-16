<?php

declare(strict_types=1);

namespace App\Twig\Component\Grid\Form;

use Sylius\Bundle\GridBundle\Form\Registry\FormTypeRegistryInterface;
use Sylius\Component\Grid\Definition\Filter;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;

class CriteriaForm extends AbstractType
{
    public function __construct(
        #[Autowire(service: 'sylius.form_registry.grid_filter')]
        private readonly FormTypeRegistryInterface $formTypeRegistry,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $filters = $options['filters'];
        Assert::allIsInstanceOf($filters, Filter::class);

        foreach ($filters as $filter) {
            $builder->add(
                $filter->getName(),
                $this->formTypeRegistry->get($filter->getType(), 'default'),
                $filter->getFormOptions(),
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'csrf_protection' => false,
            'required' => false,
            'filters' => [],
        ]);
    }
}
