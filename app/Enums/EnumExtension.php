<?php

declare(strict_types = 1);

namespace App\Enums;

use Illuminate\Support\Collection;

trait EnumExtension
{
    public function description(): string
    {
        $class = $this::class;
        $key = "enums.$class.$this->name";

        if (trans()->has($key)) {
            return (string) __($key);
        }

        return str($this->value)->ucfirst()->toString();
    }

    public function option(): array
    {
        return [
            'label' => $this->description(),
            'value' => $this->value,
        ];
    }

    public static function options(): Collection
    {
        return collect(static::cases())
            ->map(function ($value) {
                return $value->option();
            });
    }

    public static function values(): Collection
    {
        return collect(static::cases())
            ->map(function ($value) {
                return $value->value;
            });
    }
}
