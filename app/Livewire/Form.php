<?php

namespace App\Livewire;

use App\Enums\MaritalStatusEnum;
use App\Enums\PhoneCodeEnum;
use App\Models\Record;
use App\Rules\Livewire\NumberFormatRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\RequiredIf;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public string $name;
    public string $surname;
    public ?string $patronymic = null;
    public string $birthday;
    public ?string $email = null;
    public array $phones = [
        [
            'code' => PhoneCodeEnum::BELARUS,
            'number' => '',
        ]
    ];
    public MaritalStatusEnum $marital_status = MaritalStatusEnum::SINGLE;
    public ?string $about = null;
    public array $files = [];
    public bool $agreement;

    public function addPhone(): void
    {
        $this->phones[] = [
            'code' => PhoneCodeEnum::BELARUS,
            'number' => '',
        ];
    }

    public function removePhone($key): void
    {
        unset($this->phones[$key]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:50',
            'surname' => 'required|string|min:2|max:50',
            'patronymic' => 'nullable|string|min:2|max:50',
            'birthday' => 'required|date|before:now',
            'email' => [
                'nullable',
                'email',
                new RequiredIf(function () {
                    return collect($this->phones)->filter(fn($phone) => !!$phone['number'])->isEmpty();
                })
            ],
            'phones' => 'array|max:5',
            'phones.*.code' => new Enum(PhoneCodeEnum::class),
            'phones.*.number' => [
                'required_without:email',
                new NumberFormatRule($this->prepareForValidation(
                    $this->getDataForValidation(null)
                )),
            ],
            'marital_status' => ['required', new Enum(MaritalStatusEnum::class)],
            'about' => 'nullable|string|max:1000',
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|max:5120|mimes:jpg,png,pdf',
            'agreement' => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('custom.livewire.form.validation.email.required'),
            'birthday.before' => __('custom.livewire.form.validation.birthday_before'),
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'name' => __('fields.name'),
            'surname' => __('fields.surname'),
            'patronymic' => __('fields.patronymic'),
            'birthday' => __('fields.birthday'),
            'email' => __('fields.email'),
            'phones' => __('fields.phones'),
            'phones.*.code' => __('fields.phones'),
            'phones.*.number' => __('fields.phones'),
            'marital_status' => __('fields.marital_status'),
            'about' => __('fields.about'),
            'files' => __('fields.files'),
            'files.*' => __('fields.files'),
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            /** @var Record $record */
            $record = Record::query()->create([
                'name' => $this->name,
                'surname' => $this->surname,
                'patronymic' => $this?->patronymic,
                'birthday' => $this->birthday,
                'email' => $this?->email,
                'phones' => collect($this->phones)
                    ->filter(fn($phone) => !!$phone['number'])
                    ->map(fn($phone) => $phone['code']->value . $phone['number']),
                'marital_status' => $this->marital_status,
                'about' => $this?->about,
                'agreement' => $this->agreement,
            ]);

            foreach ($this->files as $file) {
                $record->addMedia($file)->toMediaCollection(Record::FILE_COLLECTION);
            }
        });

        session()->flash('message', 'Успешно');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.form')
            ->with([
                'phoneCodes' => PhoneCodeEnum::options()->toArray(),
                'maritalStatuses' => MaritalStatusEnum::options()->toArray(),
            ])
            ->extends('layouts.app');
    }
}
