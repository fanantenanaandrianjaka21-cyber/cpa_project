@extends('layouts.dynamique')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
        integrity="" crossorigin="anonymous">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="text-align:center">{{ __('Enregistrement d\'un nouveau utilisateur') }}
                    </div>
                    <div class="card-body bg-primary text-white">
                        <form method="POST" action="/ajoutUser" id="register-form">
                            @csrf

                            <div class="row mb-3">
                                <label for="nom_utilisateur"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nom') }}</label>

                                <div class="col-md-6">
                                    <input id="nom_utilisateur" type="text"
                                        class="form-control @error('nom_utilisateur') is-invalid @enderror"
                                        name="nom_utilisateur" value="{{ old('nom_utilisateur') }}" required
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
                                        name="prenom_utilisateur" value="{{ old('prenom_utilisateur') }}" required
                                        autocomplete="prenom_utilisateur" autofocus>

                                    @error('prenom_utilisateur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Matricule ') }}</label>

                                <div class="col-md-6">
                                    <input id="id" type="number"
                                        class="form-control @error('id') is-invalid @enderror"
                                        name="id" value="{{ old('id') }}" placeholder="nouveau matricule:{{ $utilisateur->id+1 }}" required
                                        autocomplete="id" autofocus>

                                    @error('id')
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
                                        name="contact_utilisateur" placeholder="Entrez le numéro">
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
                                        <option value="Administration">Administration</option>
                                        <option value="ADV">ADV</option>
                                        <option value="Audit">Audit</option>
                                        <option value="Call Adv">Call ADV</option>
                                        <option value="ComptaStar">ComptaStar</option>
                                        <option value="Formation">Formation</option>
                                        <option value="Informatique">Informatique</option>
                                        <option value="my">my</option>
                                        <option value="MyU">MyU</option>
                                        <option value="Recci">Recci</option>
                                        <option value="Serveur">Serveur</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="societe"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Societe') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="societe">
                                        <option value="ADV">CPA</option>
                                        <option value="Audit">Expert CPA</option>
                                        <option value="ComptaStar">RFC</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="id_emplacement"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Emplacement') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="id_emplacement">
                                        @if (Auth::user()->role == 'Super Admin' or Auth::user()->role == 'Admin IT')
                                            @foreach ($emplacement as $emp)
                                            @if ($emp->emplacement!='GLOBALE')
                                                <option value="{{ $emp->id }}">{{ $emp->emplacement }}</option>
                                                
                                            @endif

                                            @endforeach
                                        @else
                                            @foreach ($emplacement as $emp)
                                                @if ($emp->id == Auth::User()->id_emplacement)
                                            @if ($emp->emplacement!='GLOBALE')
                                                <option value="{{ $emp->id }}">{{ $emp->emplacement }}</option>
                                                
                                            @endif
                                                @endif
                                            @endforeach

                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="role">
                                        <option value="Utilisateur">Utilisateur</option>
                                        @if (Auth::User()->role == 'Super Admin')
                                            <option value="Technicien IT">Technicien IT</option>
                                            <option value="Responsable Site">Responsable Site</option>
                                            <option value="Admin IT">Admin IT</option>
                                            <option value="Super Admin">Super Admin</option>
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
                                        value="{{ old('email') }}" required autocomplete="email">

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
                                    <button type="reset" class="btn btn-danger"> Annuler </button>
                                    <button type="submit" class="btn btn-success">
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
