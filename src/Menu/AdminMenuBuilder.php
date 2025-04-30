<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\ItemInterface;
use Sylius\AdminUi\Knp\Menu\MenuBuilderInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(decorates: 'sylius_admin_ui.knp.menu_builder')]
final class AdminMenuBuilder implements MenuBuilderInterface
{
    public function __construct(private MenuBuilderInterface $menuBuilder)
    {
    }

    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->menuBuilder->createMenu($options);

        $menu
            ->addChild('dashboard', [
                'route' => 'sylius_admin_ui_dashboard',
            ])
            ->setLabel('sylius.ui.dashboard')
            ->setLabelAttribute('icon', 'tabler:dashboard')
        ;

        $this->addFormulaOneSubMenu($menu);

        return $menu;
    }

    private function addFormulaOneSubMenu(ItemInterface $menu): void
    {
        $formulaOne = $menu
            ->addChild('formula_one')
            ->setLabel('app.ui.formula_one')
            ->setLabelAttribute('icon', 'emojione-v1:racing-car')
        ;

        $formulaOne->addChild('admin_drivers', ['route' => 'app_admin_driver_index'])
            ->setLabel('app.ui.drivers')
        ;
    }
}
