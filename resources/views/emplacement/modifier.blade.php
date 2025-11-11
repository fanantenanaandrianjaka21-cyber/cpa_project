@extends('layouts.dynamique')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="header d-none d-lg-block">
                    <i class="fa fa-home"></i>Locale / Modification
                </div>
                <div class="card">
                    <div class="card-header" style="text-align:center">{{ __('Modification d\'un Locale') }}
                    </div>

                    <div class="card-body bg-primary text-white">
                        <form method="POST" action="{{ route('emplacement.modifier') }}" id="register-form"
                            onsubmit="return validateForm()" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="idemplacement" value="{{ $emplacement->id }}">
                            <div class="row mb-3">
                                <label for="emplacement"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Locale :') }}</label>

                                <div class="col-md-6">
                                    <input id="emplacement" type="text"
                                        class="form-control @error('emplacement') is-invalid @enderror" name="emplacement"
                                        value="{{ $emplacement->emplacement }}" required>
                                    <div class="invalid-feedback">Nom Locale invalide.</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code_emplacement"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Code Locale :') }}</label>
                                <div class="col-md-6">
                                    <input id="code_emplacement" type="text"
                                        class="form-control  @error('code_emplacement') is-invalid @enderror" name="code_emplacement"
                                        value="{{ $emplacement->code_emplacement }}" required>
                                    <div class="invalid-feedback">Code Locale invalide.</div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Modifier') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const input = document.getElementById('emplacement');
        const invalidFeedback = input.parentElement.querySelector('.invalid-feedback');
        // const validFeedback = input.parentElement.querySelector('.valid-feedback');

        const specialChars = /[!@#$%^&*(),.?":{}|<>_\-\[\]\\\/]/;
        document.addEventListener('DOMContentLoaded', function() {
            input.addEventListener('input', function() {
                if (specialChars.test(input.value)) {
                    // invalide
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                    invalidFeedback.style.display = 'block';
                    // validFeedback.style.display = 'none';
                } else if (input.value.trim() !== '') {
                    // valide
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    invalidFeedback.style.display = 'none';
                    // validFeedback.style.display = 'block';
                } else {
                    // vide → pas de message
                    input.classList.remove('is-valid', 'is-invalid');
                    invalidFeedback.style.display = 'none';
                    // validFeedback.style.display = 'none';
                }
            });
        });

        function validateForm() {
            if (specialChars.test(input.value)) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                invalidFeedback.style.display = 'block';
                // validFeedback.style.display = 'none';
                return false;
            }
        }
    </script>
@endsection
