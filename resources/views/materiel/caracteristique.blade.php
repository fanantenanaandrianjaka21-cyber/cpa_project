@extends('layouts.dynamique')
@section('content')


    @if (!empty($detail_materiel))
        <?php
        $jsId_materiel = json_encode($detail_materiel['id']);
        
        ?>
        {{-- <div class="col-lg-12"> --}}
        <div class="header">
            <i class="fa fa-home"></i>/ Details Materiels

        </div>
        <div class="w3-panel">
            <h4 class="w3-start w3-animate-right">
                Inforamtion du Materiel
            </h4>
        </div>
        <div class="card">
            <div class="card-body  bg-primary text-white" style="background-color:rgba(11, 5, 22, 0.137);">
                <table class="table table-bordered table-striped table-responsive w3-card-4">
                    <tbody>
                        <tr>
                            <th>
                                Id :

                            </th>
                            <td>
                                {{ $detail_materiel['id'] }}
                            </td>
                            <td rowspan="6">
                                <div class="text-center mt-5">
                                    <img src="{{ $detail_materiel['image'] && file_exists(public_path('storage/' . $detail_materiel['image']))
                                        ? asset('storage/' . $detail_materiel['image'])
                                        : asset('asset/imageNotfound.jpg') }}"
                                        style="   border-radius: 18px; max-width: 200px;" alt="Untree.co">
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <th>
                                Type :
                            </th>
                            <td>
                                {{ $detail_materiel['type'] }}
                            </td>

                        </tr>

                        <tr>
                            <th>
                                Marque :

                            </th>
                            <td>
                                {{ $detail_materiel['marque'] ?? '--' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Model :

                            </th>
                            <td>
                                {{ $detail_materiel['model'] ?? '--' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Numero de Serie :

                            </th>
                            <td>
                                {{ $detail_materiel['num_serie'] ?? '--' }}
                            </td>
                        </tr>


                        <tr>
                            <th>
                                Status :
                            </th>
                            <td>
                                @if ($detail_materiel['status'] == 'disponible')
                                    <span
                                        style="background-color:rgba(0, 128, 0, 0.603);color:white;border-radius:10px;padding:5px">{{ $detail_materiel['status'] }}</span>
                                @elseif ($detail_materiel['status'] == 'utiliser')
                                    <span
                                        style="background-color:rgba(35, 240, 213, 0.74);color:white;border-radius:10px;padding:5px">{{ $detail_materiel['status'] }}</span>
            </div>
        @else
            <span
                style="background-color:rgba(240, 192, 35, 0.74);color:white;border-radius:10px;padding:5px">{{ $detail_materiel['status'] }}</span>
    @endif
    </td>
    </tr>
    @foreach ($colonnes as $colonnes)
        @if ($detail_materiel[$colonnes] != '-')
            @if ($colonnes != 'Verification_physique')
                <tr>
                    <th>
                        {{ $colonnes }} :

                    </th>

                    <td colspan="2">
                        @if (strpos('test' . $colonnes, 'Etat') == true)
                            <select class="form-select" id="{{ $colonnes }}">
                                <option value="{{ $detail_materiel[$colonnes] ?? '' }}">
                                    {{ $detail_materiel[$colonnes] ?? 'Choisir ' . $colonnes }}</option>

                                <option value="TRES BON">TRES BON</option>
                                <option value="BON">BON</option>
                                <option value="MOYEN">MOYEN</option>
                                <option value="MAUVAIS">MAUVAIS</option>
                                <option value="APPRENTI">APPRENTI</option>
                            </select>
                        @else
                            <input id="{{ $colonnes }}" type="text"
                                class="form-control @error('{{ $colonnes }}') is-invalid @enderror"
                                value="{{ $detail_materiel[$colonnes] ?? '-' }}" autocomplete="{{ $colonnes }}">
                            <div class="invalid-feedback">Caractere interdit.</div>
                        @endif


                    </td>
                </tr>
            @else
                @if ($detail_materiel['Verification_physique'] == 'true')
                    <input id="Verification_physique" type="hidden" value="true">
                @else
                    <input id="Verification_physique" type="hidden" value="false">
                @endif
            @endif
        @endif
    @endforeach
    <tr>
        <th>
            Utilisateur :
        </th>
        <td colspan="2">
            @if ($detail_materiel['id_utilisateur'])
                          {{ $detail_materiel['nom_utilisateur'] }} {{ $detail_materiel['prenom_utilisateur'] }}, Equipe
            {{ $detail_materiel['equipe'] }}
            @else
            Aucun Utilisateur  
            @endif


        </td>
    </tr>
    <tr>
        <th>
            Localisation :
        </th>
        <td colspan="2">
            {{ $detail_materiel['emplacement'] }}
        </td>
    </tr>
    <tr>
        <th>
            code emplacement :
        </th>

        <td colspan="2">
            {{ $detail_materiel['code_locale'] }}


        </td>

    </tr>
    <tr>
        <th>
            Inventaire Physique Annuelle :
        </th>
        @if ($verification_physique == 'true')
            <td colspan="2">
                <span class="text-success">Terminer</span>


            </td>
        @else
            <td colspan="2">
                <span class="text-danger">Non valide</span>


            </td>
        @endif


    </tr>
    <tr>
        <th>

            {{-- <a href="/affectation/{{ $detail_materiel['id'] }}" class="btn btn-info  btn-sm m-2">Affecter
                à un utilisateur</a> --}}
            {{-- <a href="#" class="btn btn-info  btn-sm m-2" data-toggle="modal" data-target="#modal-affectation"
                onclick="document.getElementById('id01').style.display='block'"
                >Affecter
                à un utilisateur</a> --}}
            <a href="#" class="btn btn-info  btn-sm m-2" data-bs-toggle="modal"
                data-bs-target="#modal-affectation">Affecter
                à un utilisateur</a>
            {{-- @if ($detail_materiel['Verification_physique'] == 'false') --}}
            {{-- @endif --}}

        </th>
        <td colspan="2">
            @if ($page === 'materiel')
                <button id="modifier" type="button" class="btn btn-sm btn-success m-2">Mettre à jour</button>
            @else
                Clickez ici <button id="enregistrer" type="button" class="btn btn-sm btn-success m-2">Terminer</button>
                pour
                valider la verification
                Annuelle!
            @endif




        </td>
    </tr>

    </tbody>
    </table>
    {{-- <div class="row">
                <div class="col-lg-3 mb-5 mb-lg-0">
                </div>
                <div class="col-lg-4 ps-lg-3">


                    Information de ses materiels: select * from materiel where id egale {{ $ticket->id_utilisateur }} <br>
                    liste des tickets (objet an ilay ticket ) ratache a chaque materiel avec le statut resolu ou pas <br>
                    ssina bouton base de connaissance
                </div>
            </div> --}}
    </div>
    </div>

    {{-- </div> --}}

    <div id="affichagelog" class="collapse mt-4">
        <div class="col-lg-12">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Responsable</th>
                        <th>Description</th>
                        <th>Utilisateur</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                        <tr>
                            <td>{{ $activity->created_at }}</td>
                            <td>{{ optional($activity->causer)->nom_utilisateur ?? 'Système' }}</td>
                            <td>{{ $activity->description }}</td>
                            <td>{{ $activity->nom_utilisateur }}</td>
                            <td>{{ $activity->properties['attributes']['status'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    <a href="#" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#affichagelog">Voir
        Log</a>


    <!-- modal affectation -->
    <div class="modal" id="modal-affectation">
        <div class="modal-dialog modal-lg w3-animate-right">
            <div class="modal-content info">
                <div class="modal-header ">
                    <h4 class="modal-title text-primary">Ajout d'un materiel</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('affectation.faire') }}" id="register-form">
                    @csrf
                    <input type="hidden" name="id_materiel" value="{{ $detail_materiel['id'] }}" required>
                    {{-- <div class="form-group row">
                                <label for="id_emplacement"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Emplacement') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="id_emplacement" id="id_emplacement" required>
                                        <option value="">Sélectionner un emplacement</option>
                                        @if (Auth::User()->role == 'Super Admin' or Auth::User()->role == 'Admin IT')
                                            @foreach ($emplacement as $emp)
                                                <option value="{{ $emp->id }}">{{ $emp->emplacement }}</option>
                                            @endforeach
                                        @else
                                            @foreach ($emplacement as $emp)
                                                @if (Auth::User()->id_emplacement == $emp->id)
                                                    <option value="{{ $emp->id }}">{{ $emp->emplacement }}</option>
                                                @endif
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div> --}}
                    <div class="form-group row">
                        <label for="utilisateur"
                            class="col-md-4 col-form-label text-md-right">{{ __('Utilisateur') }}</label>
                        <div class="col-md-6">
                            <select class="form-select" name="id_utilisateur" id="utilisateur" required>
                                <option value="">Sélectionner un Utilisateur</option>

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
                                class="form-control @error('date_affectation') is-invalid @enderror" name="date_affectation"
                                value="{{ old('date_affectation') }}" required autocomplete="date_affectation" autofocus>
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
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script>
        const btnModifier = document.getElementById("modifier");
if (btnModifier) {
    btnModifier.addEventListener("click", function() {
            const id_materiel = {!! $jsId_materiel !!};
            fetch('/inventaire/getColonnes/' + encodeURIComponent(id_materiel))
                .then(response => response.json())
                .then(data => {
                    if (data.error) {

                        alert(data.error);
                        return;
                    }
                    // alert(data.id);

                    // Nettoyer toutes les colonnes avant
                    var col = data.colonnes;
                    var valeur = [];
                    // il faut que tu ajoute le reset scanner ici
                    for (let x in col) {
                        // document.getElementById(x).innerText = "";
                        valeur[x] = document.getElementById(`${col[x]}`).value;
                        // alert(col[x]+'valeur '+valeur[x]);
                    }

                    fetch('/inventaire/modifier', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id_materiel: id_materiel,
                                composant_manquant: 'ceci un un nouveau composant manquant',
                                composant_non_enregistre: 'ceci un un nouveau composant non enregistre',
                                // etat: document.getElementById("Etat").value,
                                etat: 'nouvel etat',
                                // observation: document.getElementById("observation").value,
                                observation: 'ceci un un nouveau observation',
                                anciencle: col,
                                valeur: valeur,

                            })
                        })
                        .then(async res => {
                            let data = await res.json();
                            if (res.ok) {
                                alert("Mise à jour enregistré avec succès !");
                            } else if (res.status === 422) {
                                // ⚠️ Erreur de validation Laravel
                                if (data.errors && data.errors.id_materiel) {
                                    alert("⚠️ " + data.errors.id_materiel[0]);
                                } else {
                                    alert("⚠️" + data.error);
                                    // alert("ancien cle :" + data.anciencle);
                                    // alert("valeur :" + data.valeur);
                                }
                            } else {


                                alert("Erreur serveur : " + (data.message || "inconnue"));
                            }
                        })
                        .catch(err => {
                            alert("❌ Erreur réseau : " + err);
                        });

                });
    });
}

const btnEnregistrer = document.getElementById("enregistrer");
if (btnEnregistrer) {
    btnEnregistrer.addEventListener("click", function() {
            const id_materiel = {!! $jsId_materiel !!};
            fetch('/inventaire/getColonnes/' + encodeURIComponent(id_materiel))
                .then(response => response.json())
                .then(data => {
                    if (data.error) {

                        alert(data.error);
                        return;
                    }
                    // alert(data.id);

                    // Nettoyer toutes les colonnes avant
                    var col = data.colonnes;
                    var valeur = [];
                    // il faut que tu ajoute le reset scanner ici
                    for (let x in col) {
                        // document.getElementById(x).innerText = "";
                        valeur[x] = document.getElementById(`${col[x]}`).value;
                        // alert(col[x]+'valeur '+valeur[x]);
                    }

                    fetch('/inventaire/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id_materiel: id_materiel,
                                composant_manquant: 'ceci un un nouveau composant manquant',
                                composant_non_enregistre: 'ceci un un nouveau composant non enregistre',
                                // etat: document.getElementById("Etat").value,
                                etat: 'nouvel etat',
                                // observation: document.getElementById("observation").value,
                                observation: 'ceci un un nouveau observation',
                                anciencle: col,
                                valeur: valeur,

                            })
                        })
                        .then(async res => {
                            let data = await res.json();
                            if (res.ok) {
                                alert("inventaire enregistré avec succès !");
                                window.location.href = "/inventaire";
                            } else if (res.status === 422) {
                                // ⚠️ Erreur de validation Laravel
                                if (data.errors && data.errors.id_materiel) {
                                    alert("⚠️ " + data.errors.id_materiel[0]);
                                } else {
                                    alert("⚠️" + data.error);
                                    // alert("ancien cle :" + data.anciencle);
                                    // alert("valeur :" + data.valeur);
                                }
                            } else {


                                alert("Erreur serveur : " + (data.message || "inconnue"));
                            }
                        })
                        .catch(err => {
                            alert("❌ Erreur réseau : " + err);
                        });

                });
    });
}
     
    
    </script>
    {{-- 
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
    </script> --}}
    @endif
@endsection
