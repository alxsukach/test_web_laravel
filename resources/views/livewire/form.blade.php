<div>
    <div class="row g-5 py-5 justify-content-center">
        <div class="col-md-8 col-10">
            @if(session()->has('message'))
                <div class="modal modal-sheet position-static d-block p-0 py-md-5" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content rounded-4 shadow">
                            <div class="modal-body p-5">
                                <h5 class="mb-0">Результат отправки формы:</h5>
                                <h2 class="fw-bold mb-0">{{ session('message') }}</h2>
                                <button type="button" @click="location.reload(); return false;" class="btn btn-lg btn-primary mt-5 w-100" data-bs-dismiss="modal">
                                    Повторить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <h4 class="mb-3">Форма</h4>
                <p class="text-secondary mb-3">Обязательно должно быть заполнено почта или телефон.</p>
                <form class="needs-validation" novalidate wire:submit.prevent="save">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">{{ __('fields.name') }}<span class="text-danger"> *</span></label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="" value="" maxlength="50">
                            <div class="invalid-feedback">
                                @error('name') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="surname" class="form-label">{{ __('fields.surname') }}<span class="text-danger"> *</span></label>
                            <input type="text" wire:model="surname" class="form-control @error('surname') is-invalid @enderror" id="surname" placeholder="" value="" maxlength="50">
                            <div class="invalid-feedback">
                                @error('surname') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="patronymic" class="form-label">{{ __('fields.patronymic') }}</label>
                            <input type="text" wire:model="patronymic" class="form-control @error('patronymic') is-invalid @enderror" id="patronymic" placeholder="" value="" maxlength="50">
                            <div class="invalid-feedback">
                                @error('patronymic') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="birthday" class="form-label">{{ __('fields.birthday') }}<span class="text-danger"> *</span></label>
                            <div class="input-group has-validation">
                                <input type="text" wire:model="birthday" class="form-control flatpickr-date @error('birthday') is-invalid @enderror" id="birthday" placeholder="" value="">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <div class="invalid-feedback">
                                    @error('birthday') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">{{ __('fields.email') }}</label>
                            <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email">
                            <div class="invalid-feedback">
                                @error('email') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">{{ __('fields.phones') }} (в международном формате)</label>

                            @foreach($phones as $key => $value)
                                <div class="input-group has-validation mb-3">
                                    <select wire:model="phones.{{ $key }}.code" class="btn btn-outline-secondary @error('phones.' . $key . '.code') is-invalid @enderror">
                                        @foreach($phoneCodes as $phoneCode)
                                            <option value="{{ $phoneCode['value'] }}">{{ $phoneCode['label'] }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" wire:model="phones.{{ $key }}.number" class="form-control @error('phones.' . $key . '.number') is-invalid @enderror" placeholder="" value="">
                                    @php if (count($phones) > 1): @endphp
                                        <button class="btn btn-danger" type="button" wire:click.prevent="removePhone({{$key}})"><i class="bi bi-trash"></i></button>
                                    @php endif; @endphp
                                    <div class="invalid-feedback">
                                        @error('phones.' . $key . '.code') {{ $message }} @enderror
                                        @error('phones.' . $key . '.number') {{ $message }} @enderror
                                    </div>
                                </div>
                            @endforeach

                            @php if (count($phones) < 5): @endphp
                                <button type="button" class="btn btn-outline-secondary w-100" wire:click.prevent="addPhone()">+</button>
                            @php endif; @endphp
                        </div>

                        <div class="col-12">
                            <label for="marital_status" class="form-label">{{ __('fields.marital_status') }}</label>
                            <select wire:model="marital_status" class="form-select @error('marital_status') is-invalid @enderror" id="marital_status">
                                @foreach($maritalStatuses as $maritalStatus)
                                    <option value="{{ $maritalStatus['value'] }}">{{ $maritalStatus['label'] }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @error('marital_status') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="about" class="form-label">{{ __('fields.about') }}</label>
                            <textarea wire:model="about" class="form-control @error('about') is-invalid @enderror" id="about" rows="3" maxlength="1000"></textarea>
                            <div class="invalid-feedback">
                                @error('about') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">{{ __('fields.files') }}</label>
                            <input type="file" wire:model="files" class="form-control @if($errors->has('files') || $errors->has('files.*')) is-invalid @endif" multiple>
                            <div class="invalid-feedback">
                                @error('files') {{ $message }} @enderror
                                @error('files.*') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" wire:model="agreement" class="form-check-input @error('agreement') is-invalid @enderror" id="agreement" required>
                            <label class="form-check-label" for="agreement">{{ __('fields.agreement') }}<span class="text-danger"> *</span></label>
                        </div>
                    </div>

                    <hr class="my-4">

                    <button class="w-100 btn btn-primary btn-lg" type="submit">Отправить</button>
                </form>
            @endif
        </div>
    </div>
    @push('scripts')
        <script type="module">
            flatpickr("input.flatpickr-date");
        </script>
    @endpush
</div>
