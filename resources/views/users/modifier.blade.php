@extends('layouts.dynamique')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<style>
    /* Assure que l'input s'étend correctement avec la librairie */
    .iti { width: 100%; }
</style>

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

                        {{-- NOM --}}
                        <div class="row mb-3">
                            <label for="nom_utilisateur" class="col-md-4 col-form-label text-md-end">Nom</label>
                            <div class="col-md-6">
                                <input id="nom_utilisateur" type="text"
                                    class="form-control @error('nom_utilisateur') is-invalid @enderror"
                                    name="nom_utilisateur" value="{{ $utilisateur->nom_utilisateur }}" required>
                                @error('nom_utilisateur')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- PRENOM --}}
                        <div class="row mb-3">
                            <label for="prenom_utilisateur" class="col-md-4 col-form-label text-md-end">Prenom</label>
                            <div class="col-md-6">
                                <input id="prenom_utilisateur" type="text"
                                    class="form-control @error('prenom_utilisateur') is-invalid @enderror"
                                    name="prenom_utilisateur" value="{{ $utilisateur->prenom_utilisateur }}" required>
                                @error('prenom_utilisateur')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- CONTACT --}}
                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">Contact</label>
                            <div class="col-md-6">
                                <input id="phone" type="tel"
                                    class="form-control @error('contact_utilisateur') is-invalid @enderror"
                                    name="contact_utilisateur"
                                    value="{{ old('contact_utilisateur', $utilisateur->contact_utilisateur) }}"
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

                        {{-- EQUIPE --}}
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-end">Equipe</label>
                            <div class="col-md-6">
                                <select class="form-select" name="equipe">
                                    <option value="{{ $utilisateur->equipe }}" selected>{{ $utilisateur->equipe }}</option>
                                    @php
                                        $equipes = [
                                            'Administration','ADV','Audit','Call Adv','ComptaStar','Formation',
                                            'Informatique','my','MyU','Recci','Serveur'
                                        ];
                                    @endphp
                                    @foreach ($equipes as $eq)
                                        @if ($eq !== $utilisateur->equipe)
                                            <option value="{{ $eq }}">{{ $eq }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- SOCIETE --}}
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-end">Societe</label>
                            <div class="col-md-6">
                                <select class="form-select" name="societe">
                                    <option value="{{ $utilisateur->societe }}" selected>{{ $utilisateur->societe }}</option>
                                    @foreach (['CPA', 'Expert CPA', 'RFC'] as $soc)
                                        @if ($soc !== $utilisateur->societe)
                                            <option value="{{ $soc }}">{{ $soc }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- EMPLACEMENT --}}
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-end">Emplacement</label>
                            <div class="col-md-6">
                                <select class="form-select" name="id_emplacement">
                                    <option value="{{ $utilisateur->id_emplacement }}" selected>
                                        {{ $utilisateur->emplacement }}
                                    </option>
                                    @if (Auth::user()->role === 'Super Admin' || Auth::user()->role === 'Admin IT')
                                        @foreach ($emplacement as $emp)
                                            @if ($emp->id !== $utilisateur->id_emplacement)
                                                <option value="{{ $emp->id }}">{{ $emp->emplacement }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        {{-- ROLE --}}
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-end">Role</label>
                            <div class="col-md-6">
                                <select class="form-select" name="role">
                                    <option value="{{ $utilisateur->role }}" selected>{{ $utilisateur->role }}</option>
                                    @php
                                        $roles = ['Utilisateur','Technicien IT','Responsable Site','Admin IT','Super Admin'];
                                    @endphp
                                    @if (Auth::user()->role == 'Super Admin')
                                        @foreach ($roles as $role)
                                            @if ($role !== $utilisateur->role)
                                                <option value="{{ $role }}">{{ $role }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $utilisateur->email }}" required>
                                @error('email')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
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

                        {{-- BOUTON --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- Scripts intl-tel-input --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
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