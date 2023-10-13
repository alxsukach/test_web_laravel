<?php

use App\Enums\MaritalStatusEnum;

return [
    MaritalStatusEnum::class => [
        MaritalStatusEnum::SINGLE->name => 'Single',
        MaritalStatusEnum::MARRIED->name => 'Married',
        MaritalStatusEnum::DIVORCED->name => 'Divorced',
        MaritalStatusEnum::WIDOW->name => 'Widow',
    ],
];
