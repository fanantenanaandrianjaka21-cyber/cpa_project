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
                    <div class="card-body bg-primary text-black">
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
                            <label for="phone" class="col-md-4 col-form-label text-md-end">Contact</label>
                            <div class="col-md-6">
                                <input id="phone" type="tel"
                                    class="form-control @error('contact_utilisateur') is-invalid @enderror"
                                    name="contact_utilisateur"
                                    value="{{ old('contact_utilisateur') }}"
                                    placeholder="Entrez le numéro">

                                {{-- Erreur Laravel (Nous ajoutons une classe pour la cibler en JS) --}}
                                @error('contact_utilisateur')
                                    <span class="invalid-feedback laravel-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                {{-- Erreur JS (Utilisée par le script intl-tel-input) --}}
                                <div id="phone-error" class="invalid-feedback"></div>
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

                        {{-- MOT DE PASSE --}}
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Mot de passe</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control password-field @error('password') is-invalid @enderror"
                                        name="password" required>
                                    <button type="button" class="btn btn-outline-secondary btn-toggle-pass">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- CONFIRMATION --}}
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Confirmation du mot de passe</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password-confirm" type="password"
                                        class="form-control password-field @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" required>
                                    <button type="button" class="btn btn-outline-secondary btn-toggle-pass">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
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
    const errorMsg = document.getElementById("phone-error");
    const form = document.getElementById('register-form');
    // Cible l'erreur de Laravel pour pouvoir la masquer si l'erreur vient du JS
    const laravelFeedback = document.querySelector('.laravel-feedback'); 

    // Initialisation intl-tel-input
    const iti = window.intlTelInput(input, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        initialCountry: "mg",
        preferredCountries: ["mg", "fr", "us"],
        separateDialCode: false
    });

    // --- LOGIQUE DE GESTION D'ERREUR MISE À JOUR ---

    // 1. Validation avant envoi du formulaire (côté client)
    form.addEventListener('submit', function (e) {
        
        // **ÉTAPE 1 : Nettoyage avant validation**
        input.classList.remove("is-invalid"); // Retire la classe invalide
        errorMsg.classList.remove("d-block"); // Masque l'erreur JS
        errorMsg.textContent = "";

        if (laravelFeedback) {
             // Réaffiche l'erreur Laravel juste pour s'assurer qu'elle n'est pas masquée
             laravelFeedback.classList.remove("d-none"); 
        }

        // **ÉTAPE 2 : Validation intl-tel-input**
        if (!iti.isValidNumber()) {
            e.preventDefault(); // Empêche l'envoi
            
            // Si le numéro est invalide, afficher l'erreur JS
            
            // 2a. Marquer l'input invalide
            input.classList.add("is-invalid");

            // 2b. Afficher le message d'erreur dans l'élément dédié
            errorMsg.textContent = "Numéro de téléphone invalide.";
            errorMsg.classList.add("d-block");
            
            // 2c. Masquer l'erreur Laravel pour éviter le conflit d'affichage
            if (laravelFeedback) {
                laravelFeedback.classList.add("d-none");
            }

            return;
        }

        // Si le numéro est valide :
        // Mettre à jour la valeur de l'input avec le numéro complet formaté (E.164)
        input.value = iti.getNumber();

        // Le formulaire se soumet normalement
    });

    // 2. Gestion dynamique des classes d'erreur lors de la saisie (INPUT)
    input.addEventListener("input", function () {
        // Au moindre changement, on retire l'erreur JS et réactive l'erreur Laravel

        // Masquer l'erreur JS
        errorMsg.classList.remove("d-block");
        errorMsg.textContent = "";
        
        // Retirer la classe 'is-invalid' (elle sera réappliquée par Laravel si l'erreur est toujours là)
        input.classList.remove("is-invalid"); 

        // Réactiver l'affichage de l'erreur Laravel (si elle était présente)
        if (laravelFeedback) {
            laravelFeedback.classList.remove("d-none");
        }
    });

    // 3. Initialisation : Si Laravel a renvoyé une erreur, on masque l'erreur JS au chargement.
    document.addEventListener('DOMContentLoaded', function() {
        // Masquer l'élément d'erreur JS au chargement pour s'assurer que l'erreur Laravel seule s'affiche si elle existe
        if (errorMsg) {
             errorMsg.classList.remove("d-block");
             errorMsg.classList.add("d-none");
        }

        // Si Laravel a renvoyé une erreur, on s'assure qu'elle est visible et l'input est marqué
        @error('contact_utilisateur')
            if (laravelFeedback) {
                laravelFeedback.classList.remove("d-none");
            }
            input.classList.add("is-invalid");
        @else
            // Si aucune erreur Laravel n'est présente, on s'assure que l'erreur JS est cachée par défaut
            if (errorMsg) {
                 errorMsg.classList.add("d-none");
            }
        @enderror
    });
</script>
@endsection
