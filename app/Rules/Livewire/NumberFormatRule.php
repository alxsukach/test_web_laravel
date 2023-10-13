<?php

namespace App\Rules\Livewire;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

readonly class NumberFormatRule implements ValidationRule
{
    public function __construct(
        protected array $data
    ) {
        //
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) {
            return;
        }

        [$generalField, $index, $field] = explode('.', $attribute);

        $code = Arr::get($this->data, "$generalField.$index.code");

        if (!preg_match($code->regex(), preg_replace('/\D+/', '', $value))) {
            $fail($attribute, 'validation.other.number_format_' . preg_replace('/\D+/', '', $code->value))
                ->translate();
        }
    }
}
