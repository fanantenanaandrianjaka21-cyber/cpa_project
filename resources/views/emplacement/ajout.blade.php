@extends('layouts.dynamique')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
        integrity="" crossorigin="anonymous">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="text-align:center">{{ __('Enregistrement d\'un nouveau emplacement') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('emplacement.ajout') }}" id="register-form">
                            @csrf
                            <div class="row mb-3">
                                <label for="code_emplacement"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Code emplacement') }}</label>
                                <div class="col-md-6">
                                    <input id="code_emplacement" type="text"
                                        class="form-control @error('code_emplacement') is-invalid @enderror"
                                        name="code_emplacement" value="{{ old('code_emplacement') }}" required
                                        autocomplete="code_emplacement" autofocus>
                                    @error('code_emplacement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="emplacement"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Emplacement') }}</label>
                                <div class="col-md-6">
                                    <input id="emplacement" type="text"
                                        class="form-control @error('emplacement') is-invalid @enderror" name="emplacement"
                                        value="{{ old('emplacement') }}" required autocomplete="emplacement" autofocus>
                                    @error('emplacement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code_final"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Code final') }}</label>
                                <div class="col-md-6">
                                    <input id="code_final" type="text"
                                        class="form-control @error('code_final') is-invalid @enderror" name="code_final"
                                        value="{{ old('code_final') }}" required autocomplete="code_final" autofocus>
                                    @error('code_final')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Enregistrer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- intl-tel-input JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js" integrity=""
        crossorigin="anonymous"></script>
    <!-- utils.js (format/validation) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

    <script>
        const input = document.querySelector("#phone");

        // init intl-tel-input
        const iti = window.intlTelInput(input, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js", // pour format/validation
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                // optionnel : détecter le pays via IP (fallback 'us' si fail)
                fetch('https://ipapi.co/json').then(res => res.json()).then(data => {
                    callback(data.country_code ? data.country_code.toLowerCase() : 'us');
                }).catch(() => callback('us'));
            },
            separateDialCode: false, // mettre true si tu veux afficher le dial code séparé du numéro
            preferredCountries: ["mg", "fr", "us"], // ex: Madagascar, France, USA
            onlyCountries: [], // laisser vide pour tous les pays, ou fournir une liste d'ISO (ex: ['mg','fr','us'])
            dropdownContainer: document.body
        });

        // Avant envoi du formulaire, on remplit phone_full avec le format E.164
        document.getElementById('phone-form').addEventListener('submit', function(e) {
            const fullNumber = iti.getNumber(); // ex: +261341234567
            document.getElementById('contact_utilisateur').value = fullNumber;

            // Optionnel : validation côté client
            if (!iti.isValidNumber()) {
                e.preventDefault();
                input.classList.add('is-invalid');
                if (!document.querySelector('.iti-error')) {
                    const div = document.createElement('div');
                    div.className = 'text-danger iti-error mt-1';
                    div.innerText = 'Numéro invalide pour le pays sélectionné.';
                    input.parentNode.appendChild(div);
                }
            }
        });

        // retire message d'erreur quand l'utilisateur change
        input.addEventListener('input', function() {
            input.classList.remove('is-invalid');
            const err = document.querySelector('.iti-error');
            if (err) err.remove();
        });
    </script>
@endsection
