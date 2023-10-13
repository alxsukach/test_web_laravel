<?php

namespace App\Enums;

enum MaritalStatusEnum: string
{
    use EnumExtension;

    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';
    case WIDOW = 'widow';
}
