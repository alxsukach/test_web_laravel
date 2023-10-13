<?php

return [
    'livewire' => [
        'form' => [
            'validation' => [
                'email' => [
                    'required' => 'The :attribute field is required when Phone is not present.'
                ],
                'birthday' => [
                    'before' => 'The :attribute field must be a date before now.'
                ],
            ],
            'text' => [
                'form_title' => 'Форма',
                'form_description' => 'Обязательно должно быть заполнено почта или телефон.',
                'form_result_title' => 'Результат отправки формы:',
                'phones_description' => '(в международном формате)',
                'successfully' => 'Успешно',
            ],
        ]
    ]
];
