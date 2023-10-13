<?php

namespace App\Enums;

enum PhoneCodeEnum: string
{
    use EnumExtension;

    case RUSSIA = '+7';
    case BELARUS = '+375';

    public function regex(): string
    {
        return match ($this) {
            self::RUSSIA => '/^(?:[0-9]){9}$/',
            self::BELARUS => '/^(?:0){0,1}(?:[0-9]){9}$/',
        };
    }
}
