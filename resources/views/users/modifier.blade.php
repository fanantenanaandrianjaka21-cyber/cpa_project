@extends('layouts.dynamique')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
        integrity="" crossorigin="anonymous">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="header">
                    <i class="fa fa-home"></i>/ Modification Utilisateur

                </div>
                <div class="w3-panel">
                    <h4 class="w3-start w3-animate-right">
                        Modification d'un Utilisateur
                    </h4>
                </div>
                <div class="card">

                    <div class="card-body bg-primary text-black">
                        <form method="POST" action="{{ route('utilisateur.modifier') }}" id="register-form">
                            @csrf
                            <input type="hidden" name="idutilisateur" value="{{ $utilisateur->id }}">
                            <div class="row mb-3">
                                <label for="nom_utilisateur"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nom') }}</label>

                                <div class="col-md-6">
                                    <input id="nom_utilisateur" type="text"
                                        class="form-control @error('nom_utilisateur') is-invalid @enderror"
                                        name="nom_utilisateur" value="{{ $utilisateur->nom_utilisateur }}" required
                                        autocomplete="nom_utilisateur" autofocus>

                                    @error('nom_utilisateur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="prenom_utilisateur"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Prenom') }}</label>

                                <div class="col-md-6">
                                    <input id="prenom_utilisateur" type="text"
                                        class="form-control @error('prenom_utilisateur') is-invalid @enderror"
                                        name="prenom_utilisateur" value="{{ $utilisateur->prenom_utilisateur }}" required
                                        autocomplete="prenom_utilisateur" autofocus>

                                    @error('prenom_utilisateur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="phone"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Contact') }}</label>
                                <div class="col-md-6">
                                    <!-- Champ visuel -->
                                    <input id="phone" type="tel"
                                        class="form-control @error('contact_utilisateur') is-invalid @enderror"
                                        name="contact_utilisateur" value="{{ $utilisateur->contact_utilisateur }}"
                                        placeholder="Entrez le numéro">


                                    @error('contact_utilisateur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="equipe"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Equipe') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="equipe">
                                        @php
                                            $equipe = [
                                                'Administration',
                                                'ADV',
                                                'Audit',
                                                'Call Adv',
                                                'ComptaStar',
                                                'Formation',
                                                'Informatique',
                                                'my',
                                                'MyU',
                                                'Recci',
                                                'Serveur',
                                            ];
                                        @endphp
                                        <option value="{{ $utilisateur->equipe }}" selected>
                                            {{ $utilisateur->equipe }}
                                        </option>
                                        @foreach ($equipe as $equipe)
                                            @if ($equipe !== $utilisateur->equipe)
                                                <option value="{{ $equipe }}">{{ $equipe }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="societe"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Societe') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="societe">
                                        @php
                                            $societe = ['CPA', 'Expert CPA', 'RFC'];
                                        @endphp
                                        <option value="{{ $utilisateur->societe }}" selected>
                                            {{ $utilisateur->societe }}
                                        </option>
                                        @foreach ($societe as $societe)
                                            @if ($societe !== $utilisateur->societe)
                                                <option value="{{ $societe }}">{{ $societe }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="id_emplacement"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Emplacement') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="id_emplacement" id="id_emplacement">
                                        <option value="{{ $utilisateur->id_emplacement }}" selected>
                                            {{ $utilisateur->emplacement }}
                                        </option>
                                        @if (Auth::User()->role == 'Super Admin' or Auth::User()->role == 'Admin IT')
                                            @foreach ($emplacement as $emp)
                                                @if ($emp->id !== $utilisateur->id_emplacement)
                                                    <option value="{{ $emp->id }}">{{ $emp->emplacement }}</option>
                                                @endif
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="role"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="role">
                                        @php
                                            $roles = [
                                                'Utilisateur',
                                                'Technicien IT',
                                                'Responsable Site',
                                                'Admin IT',
                                                'Super Admin',
                                            ];
                                        @endphp
                                        <option value="{{ $utilisateur->role }}" selected>{{ $utilisateur->role }}
                                        </option>
                                        @if (Auth::User()->role == 'Super Admin')
                                            @foreach ($roles as $role)
                                                @if ($role !== $utilisateur->role)
                                                    <option value="{{ $role }}">{{ $role }}</option>
                                                @endif
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $utilisateur->email }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Mot de passe') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>La confirmation du mot de passe est incorrecte</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- asina etoil en rouge ny champ obligatoir -->
                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirmation du mot de passe') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
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
    <!-- Scripts -->


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
