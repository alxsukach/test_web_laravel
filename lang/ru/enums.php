<?php

use App\Enums\MaritalStatusEnum;

return [
    MaritalStatusEnum::class => [
        MaritalStatusEnum::SINGLE->name => 'Холост/не замужем',
        MaritalStatusEnum::MARRIED->name => 'Женат/замужем',
        MaritalStatusEnum::DIVORCED->name => 'В разводе',
        MaritalStatusEnum::WIDOW->name => 'Вдовец/вдова',
    ],
];
