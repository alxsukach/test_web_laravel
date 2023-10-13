<?php

return [
    'livewire' => [
        'form' => [
            'validation' => [
                'email' => [
                    'required' => 'Поле :attribute обязательно для заполнения, когда Телефон не указано.',
                ],
                'birthday' => [
                    'before' => 'Значение поля :attribute должно быть датой до сегодня.',
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
