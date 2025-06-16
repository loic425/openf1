<?php

namespace App\Grid\Template;

enum FilterTemplate: string
{
    case DATE = 'shared/grid/filter/real_time/date.html.twig';
    case SELECT = 'shared/grid/filter/real_time/select.html.twig';
    case STRING = 'shared/grid/filter/real_time/string.html.twig';
}
