@extends('layouts.dynamique')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
        integrity="" crossorigin="anonymous">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="text-align:center">{{ __('Affectation') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('affectation.faire') }}" id="register-form">
                            @csrf
                            <input type="hidden" name="id_materiel" value="{{ $id }}" required>
                            <div class="form-group row">
                                <label for="id_emplacement"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Emplacement') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="id_emplacement" id="id_emplacement" required>
                                        <option value="">Sélectionner un emplacement</option>
                                        @foreach ($emplacement as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->emplacement }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="utilisateur"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Utilisateur') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="id_utilisateur" id="utilisateur" required>
                                        @foreach ($utilisateur as $uti)
                                            <option value="{{ $uti->id }}">{{ $uti->nom_utilisateur }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="date_affectation"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Date d\'affectation') }}</label>

                                <div class="col-md-6">
                                    <input id="date_affectation" type="date"
                                        class="form-control @error('date_affectation') is-invalid @enderror"
                                        name="date_affectation" value="{{ old('date_affectation') }}" required
                                        autocomplete="date_affectation" autofocus>
                                    @error('date_affectation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emplacementSelect = document.getElementById('id_emplacement');
            const utilisateurSelect = document.getElementById('utilisateur');
            const baseUrl = "/utilisateurs/par-emplacement"; // /utilisateurs/par-emplacement

            function resetUtilisateur(text = ' Sélectionner un utilisateur') {
                utilisateurSelect.innerHTML = '<option value="">' + text + '</option>';
                utilisateurSelect.disabled = true;
            }

            // initial
            resetUtilisateur();

            emplacementSelect.addEventListener('change', function() {
                const id = this.value;

                resetUtilisateur('Chargement…');
                // resetUtilisateur();

                if (!id) {
                    resetUtilisateur();
                    return;
                }
                const url = baseUrl + '/' + encodeURIComponent(id);
                const xhttp = new XMLHttpRequest();

                // si la requête traverse des domaines différents et que tu veux envoyer cookies :
                // xhttp.withCredentials = true;

                xhttp.onload = function() {
                    // status 200-299 => OK

                    if (this.status >= 200 && this.status < 300) {
                        try {

                            const data = JSON.parse(this.responseText);
                            utilisateurSelect.innerHTML =
                                '<option value="">Sélectionner un utilisateur</option>';
                            if (!Array.isArray(data) || data.length === 0) {
                                const opt = document.createElement('option');
                                opt.value = '';
                                opt.text = 'Aucun utilisateur';
                                utilisateurSelect.appendChild(opt);
                            } else {
                                data.forEach(function(u) {
                                    const opt = document.createElement('option');
                                    opt.value = u.id;
                                    // sécurité : si le champ attendu est différent (ex: name), on le gère
                                    opt.text = u.nom_utilisateur ?? u.name ?? ('Utilisateur ' +
                                        u.id);
                                    utilisateurSelect.appendChild(opt);
                                });
                            }
                        } catch (err) {
                            console.error('Erreur JSON:', err, this.responseText);
                            utilisateurSelect.innerHTML =
                                '<option value="">Erreur lecture des données</option>';
                        }
                    } else {
                        console.error('Erreur HTTP:', this.status, this.responseText);
                        utilisateurSelect.innerHTML = '<option value="">Erreur chargement (' + this
                            .status + ')</option>';
                    }
                    utilisateurSelect.disabled = false;
                };

                xhttp.onerror = function() {
                    console.error('Erreur réseau');
                    utilisateurSelect.innerHTML = '<option value="">Erreur réseau</option>';
                    utilisateurSelect.disabled = false;
                };

                xhttp.open('GET', url, true);
                // indique que c'est une requête AJAX (utile côté serveur/middleware)
                xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhttp.send();
            });
        });
    </script>
@endsection
