<?php

declare(strict_types=1);

namespace App\Grid\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamFilterType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => $this->getChoices(),
            'placeholder' => 'Choose a team',
            'autocomplete' => true,
        ]);
    }

    #[\Override]
    public function getParent(): string
    {
        return ChoiceType::class;
    }

    private function getChoices(): array
    {
        $teams = [
            'Alfa Romeo',
            'AlphaTauri',
            'Alpine',
            'Aston Martin',
            'Ferrari',
            'Haas F1 Team',
            'McLaren',
            'Mercedes',
            'Red Bull Racing',
            'Williams',
        ];

        $choices = [];

        foreach ($teams as $team) {
            $choices[$team] = $team;
        }

        return $choices;
    }
}



