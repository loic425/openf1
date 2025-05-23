<?php

namespace App\Grid\Template;

enum FieldTemplate: string
{
    case DATETIME = 'shared/grid/field/datetime.html.twig';
    case COLOR = 'shared/grid/field/color.html.twig';
}
