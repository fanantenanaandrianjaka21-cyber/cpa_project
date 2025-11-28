@extends('layouts.dynamique')

@section('content')
    <?php
    $type_poste = ['Accès Biostar', 'Décodeur Caméra', 'Écran plat', 'Onduleur', 'Ordinateur portable', 'Outils de communication', 'Répéteur Wi-Fi', 'Routeur', 'Stabilisateur', 'Stockage amovible', 'Switch', 'Unité centrale', 'Vidéo projecteur', 'Frigidaire', 'Imprimante'];
    $type_consomable = ['Clavier', 'Souris', 'Câble alimentation', 'Adaptateur USB', 'Adaptateur HDMI', 'Adaptateur LAN', 'Microcasque', 'Clé USB', 'Câble VGA', 'Câble HDMI', 'Câble réseau', 'Connecteur réseau', 'Adaptateur prise', 'Rallonge multiple'];
    // Encode les tableaux PHP vers du JSON utilisable en JS
    $jsTypePoste = json_encode($type_poste);
    $jsTypeConsommable = json_encode($type_consomable);
    ?>
    <div class="header d-none d-lg-block">
        <i class="fa fa-home"></i>/ Stocks / Materiels en Stock

    </div>
    <div class="w3-panel">
        <h4 class="w3-start w3-animate-right">
            Liste des Materiels en Stock
        </h4>
    </div>
    <div class="card">

        <div class="card-body bg-primary text-black">
            <div class="row">
                <div class="col-12">
                    @if (session('notification'))
                        <div class='alert alert-success'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <i class='fa fa-close'></i>
                            </button>
                            <span>
                                <b><i class='fa fa-bell'></i> Success - </b>{{ session('notification') }}
                            </span>
                        </div>
                    @endif
                    @if (session('erreur'))
                        <div class='alert alert-danger'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <i class='fa fa-close'></i>
                            </button>
                            <span>
                                <b><i class='fa fa-bell'></i> Erreur - </b>{{ session('notification') }}
                            </span>
                        </div>
                    @endif
                    <?php
                    if (isset($notification['success'])) {
                        echo "<div class='alert alert-success'>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i class='fa fa-close'></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <b><i class='fa fa-bell'></i>  Success - </b>" .
                            $notification['success'] .
                            "</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>";
                    }
                    if (isset($notification['erreur'])) {
                        echo "<div class='alert alert-danger'>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i class='fa fa-close'></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <b><i class='fa fa-bell'></i>  Erreur - </b> Materiel non enregistré : " .
                            $notification['erreur'] .
                            "</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>";
                    }
                    ?>
                    {{-- <a href=""class="btn btn-success btn-round" data-toggle="modal" data-target="#modal-materiel"><i
                            class="fa fa-plus"></i> Stock</a> --}}
                    <a href=""class="btn btn-success btn-round" data-bs-toggle="modal"
                        data-bs-target="#modal-materiel"><i class="fa fa-plus"></i> Stock</a>
                    <a
                        href="{{ route('mouvement.liste', ['id_emplacement' => Auth::user()->id_emplacement, 'role' => Auth::user()->role]) }}"class="btn btn-success btn-round">Mouvement
                        de Stock</a>
                    <h3>
                        Legende :
                    </h3>
                    Seuil Minimal :
                    <span class="badge bg-danger p-2 mr-2" style="width:2%">

                    </span>
                    Seuil Critique :
                    <span class="badge bg-warning p-2 mr-2" style="width:2%">

                    </span>
                    Stock Optimal :
                    <span class="badge bg-success p-2 mr-2" style="width:2%">

                    </span>
                    <table class="table table-bordered table-hover table-responsive mt-2">
                        <thead>
                            <tr>
                                <th rowspan="2"style="text-align: center">Materiel</th>
                                {{-- <th rowspan="2"style="text-align: center">Model</th> --}}
                                <th colspan="4"style="text-align: center">Quantité disponible</th>
                                <th rowspan="2"style="text-align: center">Action</th>
                            </tr>
                            <tr>
                                <th colspan="2" style="text-align: center">Non Distribué</th>
                                <th colspan="2" style="text-align: center">Distribué</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materielpartype as $materielpartype)
                                <tr>
                                    <td class="align-content-around">{{ $materielpartype['type'] }}</td>
                                    <td colspan="2"class="text-center align-content-around">

                                        <a
                                            href="{{ route('materiel.partype_par_centre', ['type' => $materielpartype['type'], 'id_emplacement' => 1]) }}">
                                            {{ $materielpartype['non_distribue'] }}
                                        </a>
                                    </td>
                                    <td class="text-center align-content-around">
                                        Total en stock : {{ $materielpartype['quantite'] }}
                                    </td>
                                    <td class="justify-content-between">
                                        @foreach ($materielpartype['materielemplacement'] as $materielemplacement)
                                            <div style="border-bottom: 1px solid rgb(12, 11, 11); padding: 5px;">

                                                @php
                                                    // Recherche de l'alerte correspondant au type du matériel actuel
$alerteCorrespondante = collect($alert)->firstWhere(
    'type_materiel',
    $materielemplacement['emplacement'][0]['type'],
                                                    );
                                                @endphp

                                                <a
                                                    href="{{ route('materiel.partype_par_centre', [
                                                        'type' => $materielpartype['type'],
                                                        'id_emplacement' => $materielemplacement['id_emplacement'],
                                                    ]) }}">
                                                    {{ $materielemplacement['nom_emplacement'] }} :
                                                </a>

                                                @if ($alerteCorrespondante)
                                                    {{-- Vérifie les seuils par rapport à l'alerte correspondante --}}
                                                    @if ($materielemplacement['quantite'] > 0 && $materielemplacement['quantite'] <= $alerteCorrespondante->niveau_seuil)
                                                        <span class="badge bg-danger ml-3" style="width:10%">
                                                            {{ $materielemplacement['quantite'] }}
                                                        </span>
                                                    @elseif (
                                                        $materielemplacement['quantite'] > $alerteCorrespondante->niveau_seuil &&
                                                            $materielemplacement['quantite'] <= $alerteCorrespondante->niveau_critique)
                                                        <span class="badge bg-warning ml-3" style="width:10%">
                                                            {{ $materielemplacement['quantite'] }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success ml-3" style="width:10%">
                                                            {{ $materielemplacement['quantite'] }}
                                                        </span>
                                                    @endif
                                                @else
                                                    {{-- Si aucune alerte ne correspond au type --}}
                                                    <span class="badge bg-secondary ml-3" style="width:10%">
                                                        {{ $materielemplacement['quantite'] }}
                                                    </span>
                                                @endif

                                            </div>
                                        @endforeach


                                    </td>
                                    {{-- <td class="text-center">
                                        <span
                                            style="background-color:rgba(0, 128, 0, 0.603);color:white;border-radius:10px;padding:5px;">Disponible</span>

                                    </td> --}}
                                    <td class="text-center align-content-around">
                                        <a href="{{ route('materiel.partype_centre', $materielpartype['type']) }}"
                                            class="btn btn-outline-info btn-xs ">Voir tous</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- modal materiel -->
    <div class="modal fade" id="modal-materiel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content info">
                <div class="modal-header ">
                    <h4 class="modal-title text-primary">Ajout d'un materiel</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('materiel.ajout_materiel') }}" id="register-form"
                    enctype="multipart/form-data" onsubmit="return validateForm()" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body color-secondary text-black">
                        <div id="etape1">
                            <input type="hidden" name='id_utilisateur' value="">
                            <div class="form-group row">
                                <label for="id_emplacement" id="id_emplacement"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Emplacement :') }}<strong
                                        class="text-danger m-2 mt-2">*</strong></label>
                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="id_emplacement"
                                        required>
                                        <option value="">Choisir emplacement de stock</option>
                                        @if (!empty($emplacement))
                                            @if (Auth::User()->role == 'Super Admin' or Auth::User()->role == 'Admin IT')
                                                @foreach ($emplacement as $emplacement)
                                                    <option value="{{ $emplacement->id }}">{{ $emplacement->emplacement }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach ($emplacement as $emplacement)
                                                    @if (Auth::User()->id_emplacement == $emplacement->id)
                                                        <option value="{{ $emplacement->id }}">
                                                            {{ $emplacement->emplacement }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif

                                        @endif
                                    </select>
                                    <div class="invalid-feedback">Veuillez selectionner un local.</div>

                                </div>
                            </div>

                            {{-- Radios --}}
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end">{{ __('Catégorie :') }}</label>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="radio1" name="categorie"
                                            value="poste" checked>
                                        <label class="form-check-label" for="radio1">Matériel Informatique</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="radio2" name="categorie"
                                            value="consommable">
                                        <label class="form-check-label" for="radio2">Consommable</label>
                                    </div>
                                </div>
                            </div>

                            {{-- Select dynamique --}}
                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Type :') }}
                                    <strong class="text-danger m-2 mt-2">*</strong>
                                </label>
                                <div class="col-md-6">
                                    <select class="form-select" name="type" id="typeSelect" required>
                                        <option value="">Choisir le type</option>
                                        {{-- Options injectées via JavaScript --}}
                                    </select>
                                    <div class="invalid-feedback">Veuillez sélectionner un type.</div>
                                </div>
                            </div>

                            <div class="row mb-3" id="codeInterneWrapper">
                                <label for="code_interne" class="col-md-4 col-form-label text-md-end">
                                    {{ __('Code interne :') }}
                                    <strong class="text-danger m-2 mt-2">*</strong>
                                </label>
                                <div class="col-md-6">
                                    <input id="code_interne" type="text"
                                        class="form-control @error('code_interne') is-invalid @enderror"
                                        name="code_interne" value="{{ old('code_interne') }}"
                                        autocomplete="code_interne" autofocus>
                                    <div class="invalid-feedback">Code interne invalide.</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="date_aquisition"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Date aquisition :') }}<strong
                                        class="text-danger m-2 mt-2">*</strong></label>

                                <div class="col-md-6">
                                    <input id="date_aquisition" type="date"
                                        class="form-control @error('date_aquisition') is-invalid @enderror"
                                        name="date_aquisition" value="{{ old('date_aquisition') }}" required
                                        autocomplete="date_aquisition">
                                    <div class="invalid-feedback">Champ obligatoire.</div>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="quantite"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Quantite :') }}<strong
                                        class="text-danger m-2 mt-2">*</strong></label>
                                <div class="col-md-6">
                                    <input id="quantite" type="number"
                                        class="form-control @error('quantite') is-invalid @enderror" name="quantite"
                                        value="{{ old('quantite') }}" autocomplete="quantite" required>
                                    <div class="invalid-feedback">Champ obligatoir.</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="marque"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Marque :') }}<strong
                                        class="text-danger m-2 mt-2">*</strong></label>
                                <div class="col-md-6">
                                    <input id="marque" type="text"
                                        class="form-control @error('marque') is-invalid @enderror" name="marque"
                                        value="{{ old('marque') }}" autocomplete="marque" required>
                                    <div class="invalid-feedback">Caractere interdit.</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="model"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Model : ') }}</label>
                                <div class="col-md-6">
                                    <input id="model" type="text"
                                        class="form-control @error('model') is-invalid @enderror" name="model"
                                        value="{{ old('model') }}" autocomplete="model">
                                    <div class="invalid-feedback">Caractere interdit.</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="serie"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Numero de Serie :') }}</label>
                                <div class="col-md-6">
                                    <input id="num_serie" type="text"
                                        class="form-control @error('num_serie') is-invalid @enderror" name="num_serie"
                                        value="{{ old('num_serie') }}">
                                    <div class="invalid-feedback">Caractere interdit.</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="etat" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Etat :') }}
                                    <strong class="text-danger m-2 mt-2">*</strong>
                                </label>
                                <div class="col-md-6">
                                    <input type="hidden" name="cles[]" value="Etat"class="form-control">
                                    <select class="form-select" name="valeurs[]" id="typeSelect" required>
                                        <option value="">Choisir etat materiel</option>
                                        <option value="TRES BON">TRES BON</option>
                                        <option value="BON">BON</option>
                                        <option value="MOYEN">MOYEN</option>
                                        <option value="MAUVAIS">MAUVAIS</option>
                                        <option value="APPRENTI">APPRENTI</option>
                                    </select>
                                    <div class="invalid-feedback">Veuillez sélectionner un etat.</div>
                                </div>
                            </div>
                            <input type="hidden" name="cles[]" value="Verification_physique">
                            <input type="hidden" name="valeurs[]" value="false">
                            {{-- <input type="hidden" name="cles[]" value="Observation">
                            <input type="hidden" name="valeurs[]" value=""> --}}
                            <input id="status" type="hidden" name="status" value="disponible">
                            <div class="row mb-3">
                                <label for="image" class="col-md-4 col-form-label text-md-end">Image :</label>
                                <div class="col-md-6">
                                    <input class="form-control-file border" type="file" name="image" />
                                    <div class="invalid-feedback">Veuillez choisir un image.</div>
                                </div>
                            </div>
                        </div>
                        <div id="etape2" style="display: none;">
                            <h5>Champs suplemantaire</h5>
                            <div id="pc">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-md-start">Processeur : </label>

                                        <input type="hidden" name="cles[]" value="Processeur"class="form-control">

                                        <div class="col-md-12">
                                            <input type="text" name="valeurs[]" class="form-control">
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-md-start">Ram : </label>

                                        <input type="hidden" name="cles[]" value="Ram"class="form-control">

                                        <div class="col-md-12">
                                            <input type="text" name="valeurs[]" class="form-control">
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <label class="text-md-start">Disque : </label>

                                        <input type="hidden" name="cles[]" value="Disque"class="form-control">

                                        <div class="col-md-12">
                                            <input type="text" name="valeurs[]" class="form-control">
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-md-start">Etat Batterie : </label>

                                        <input type="hidden" name="cles[]" value="Etat Baterie"class="form-control">

                                        <div class="col-md-12">
                                            <select class="form-select" name="valeurs[]" id="typeSelect">
                                                <option value="">Choisir etat Batterie</option>
                                                <option value="TRES BON">TRES BON</option>
                                                <option value="BON">BON</option>
                                                <option value="MOYEN">MOYEN</option>
                                                <option value="MAUVAIS">MAUVAIS</option>
                                                <option value="APPRENTI">APPRENTI</option>
                                            </select>
                                            <div class="invalid-feedback">Veuillez sélectionner un etat.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-md-start">HDMI : </label>

                                        <input type="hidden" name="cles[]" value="Etat HDMI"class="form-control">

                                        <div class="col-md-12">
                                            <select class="form-select" name="valeurs[]" id="typeSelect">
                                                <option value="">Choisir valeur HDMI</option>
                                                <option value="VRAI">Vrai</option>
                                                <option value="FAUX">Faux</option>
                                                {{-- <option value="TRES BON">TRES BON</option>
                                                <option value="BON">BON</option>
                                                <option value="MOYEN">MOYEN</option>
                                                <option value="MAUVAIS">MAUVAIS</option>
                                                <option value="APPRENTI">APPRENTI</option> --}}
                                            </select>
                                            <div class="invalid-feedback">Veuillez sélectionner un etat.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-md-start">Clavier : </label>

                                        <input type="hidden" name="cles[]" value="Etat Clavier"class="form-control">

                                        <div class="col-md-12">
                                            <select class="form-select" name="valeurs[]" id="typeSelect">
                                                <option value="">Choisir valeur Clavier</option>
                                                <option value="VRAI">Vrai</option>
                                                <option value="FAUX">Faux</option>
                                                {{-- <option value="TRES BON">TRES BON</option>
                                                <option value="BON">BON</option>
                                                <option value="MOYEN">MOYEN</option>
                                                <option value="MAUVAIS">MAUVAIS</option>
                                                <option value="APPRENTI">APPRENTI</option> --}}
                                            </select>
                                            <div class="invalid-feedback">Veuillez sélectionner un etat.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-md-start">Lan : </label>

                                        <input type="hidden" name="cles[]" value="Etat Souris"class="form-control">

                                        <div class="col-md-12">
                                            <select class="form-select" name="valeurs[]" id="typeSelect">
                                                <option value="">Choisir valeur Lan</option>
                                                <option value="VRAI">Vrai</option>
                                                <option value="FAUX">Faux</option>
                                                {{-- <option value="TRES BON">TRES BON</option>
                                                <option value="BON">BON</option>
                                                <option value="MOYEN">MOYEN</option>
                                                <option value="MAUVAIS">MAUVAIS</option>
                                                <option value="APPRENTI">APPRENTI</option> --}}
                                            </select>
                                            <div class="invalid-feedback">Veuillez sélectionner un etat.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-md-start">USB: </label>

                                        <input type="hidden" name="cles[]" value="Etat Micro"class="form-control">

                                        <div class="col-md-12">
                                            <select class="form-select" name="valeurs[]" id="typeSelect">
                                                <option value="">Choisir valeur USB</option>
                                                <option value="VRAI">Vrai</option>
                                                <option value="FAUX">Faux</option>
                                                {{-- <option value="TRES BON">TRES BON</option>
                                                <option value="BON">BON</option>
                                                <option value="MOYEN">MOYEN</option>
                                                <option value="MAUVAIS">MAUVAIS</option>
                                                <option value="APPRENTI">APPRENTI</option> --}}
                                            </select>
                                            <div class="invalid-feedback">Veuillez sélectionner un etat.</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="text-md-start">Mots de passe PC : </label>

                                        <input type="hidden" name="cles[]" value="Mdp PC"class="form-control">
                                        <div class="input-group col-md-12">
                                            <input type="password" name="valeurs[]" class="form-control password-field">
                                            <button type="button" class="btn btn-outline-secondary toggle-password">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-md-start">Mots de passe ADMIN : </label>

                                        <input type="hidden" name="cles[]" value="Mdp Admin"class="form-control">
                                        <div class="input-group col-md-12">
                                            <input type="password" name="valeurs[]" class="form-control password-field">
                                            <button type="button" class="btn btn-outline-secondary toggle-password">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="champs">
                                <div id="champs-pair">

                                </div>
                            </div>
                            <button type="button" onclick="ajouterChamp()">➕ Ajouter plus de
                                caracteristque</button><br><br>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" id="btn-precedent" class="btn btn-outline-secondary"
                            style="display:none;" onclick="afficherEtape(1)">← Précédent</button>
                        <button type="button" id="btn-suivant" class="btn btn-outline-primary"
                            onclick="afficherEtape(2)">Suivant →</button>
                        <button type="submit" class="btn btn-outline-success">Terminer</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- script fonction ajout champ -->
    <script>
        function ajouterChamp() {
            const container = document.getElementById('champs');

            const div = document.createElement('div');
            div.className = 'row mb-3 champ-pair';
            div.innerHTML = `
                <label class="col-md-2 col-form-label text-md-end">Clé : </label>
                <div class="col-md-4">
                    <input type="text" name="cles[]" class="form-control">
                    <div class="invalid-feedback">Champ obligatoire.</div>
                </div>
                <label class="col-md-2 col-form-label text-md-end">Valeur : </label>
                <div class="col-md-4">
                    <input type="text" name="valeurs[]" class="form-control">
                    <div class="invalid-feedback">Champ obligatoire.</div>
                </div>
            `;
            container.appendChild(div);
        }

        // affiche etape

        function afficherEtape(etape) {
            if (etape === 2) {
                document.getElementById('etape1').style.display = 'none';
                document.getElementById('etape2').style.display = 'block';
                document.getElementById('btn-suivant').style.display = 'none';
                document.getElementById('btn-precedent').style.display = 'inline-block';
            } else {
                document.getElementById('etape1').style.display = 'block';
                document.getElementById('etape2').style.display = 'none';
                document.getElementById('btn-suivant').style.display = 'inline-block';
                document.getElementById('btn-precedent').style.display = 'none';
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register-form');
            const inputs = form.querySelectorAll('input, select, textarea', 'number'); // tous les champs

            const regexNoSpecial = /^[A-Za-z0-9\s\-]+$/; // lettres, chiffres, espaces et tirets

            // Helpers pour Bootstrap
            function valide(input, feedback) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                if (feedback) feedback.style.display = 'none';
            }

            function invalide(input, feedback, message) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                if (feedback) {
                    feedback.textContent = message;
                    feedback.style.display = 'block';
                }
            }

            function neutral(input, feedback) {
                input.classList.remove('is-valid', 'is-invalid');
                if (feedback) feedback.style.display = 'none';
            }

            // Validation en direct pour tous les champs
            inputs.forEach(input => {
                const feedback = input.parentElement.querySelector('.invalid-feedback');

                // --- Champs texte / textarea ---
                if (input.type === 'text' || input.tagName === 'TEXTAREA') {
                    input.addEventListener('input', () => {
                        if (input.value.trim() === '') {
                            neutral(input, feedback); // vide = neutre
                        } else if (!regexNoSpecial.test(input.value)) {
                            invalide(input, feedback, "Caractères spéciaux non autorisés.");
                        } else {
                            valide(input, feedback);
                        }
                    });
                }
                //input type number
                if (input.type === 'number') {
                    input.addEventListener('input', () => {
                        const value = input.value.trim();
                        const number = Number(value);

                        if (value === '') {
                            neutral(input, feedback); // champ vide
                        } else if (isNaN(number)) {
                            invalide(input, feedback, "Valeur non numérique.");
                        } else if (number < 0) {
                            invalide(input, feedback,
                                "Les nombres négatifs ne sont pas autorisés.");
                        } else {
                            valide(input, feedback);
                        }
                    });
                }
                // --- Champs select ---
                if (input.tagName.toLowerCase() === 'select') {
                    input.addEventListener('change', () => {
                        if (input.required && input.value === '') {
                            invalide(input, feedback, "Veuillez faire un choix.");
                        } else {
                            valide(input, feedback);
                        }
                    });
                }

                // --- Champs date ---
                if (input.type === 'date') {
                    input.addEventListener('change', () => {
                        const today = new Date();
                        const valueDate = new Date(input.value);
                        if (input.required && input.value === '') {
                            invalide(input, feedback, "Date requise.");
                        } else if (valueDate > today) {
                            invalide(input, feedback, "La date ne peut pas être dans le futur.");
                        } else {
                            valide(input, feedback);
                        }
                    });
                }

                // --- Champ fichier image (.jpg uniquement, max 2 Mo) ---
                if (input.type === 'file') {
                    input.addEventListener('change', () => {
                        const file = input.files[0];
                        if (!file) {
                            if (input.required) invalide(input, feedback,
                                "Veuillez choisir une image.");

                        } else if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
                            invalide(input, feedback, "Le fichier doit être au format jpg,jpeg.");
                            input.value = '';;
                        } else if (file.size > 2 * 1024 * 1024) {
                            invalide(input, feedback, "L'image ne doit pas dépasser 2 Mo.");
                            input.value = '';
                            if (previewImage) previewImage.src =
                                "{{ asset('images/default.jpg') }}";
                        } else {
                            valide(input, feedback);

                        }
                    });
                }
            });

            // Validation finale avant soumission
            form.addEventListener('submit', function(e) {
                let isValid = true;

                inputs.forEach(input => {
                    const feedback = input.parentElement.querySelector('.invalid-feedback');

                    // Champs requis
                    if (input.required && input.value.trim() === '') {
                        invalide(input, feedback, "Ce champ est obligatoire.");
                        isValid = false;
                    }

                    // Champs texte / textarea -> caractères spéciaux
                    if ((input.type === 'text' || input.tagName === 'TEXTAREA') && input.value
                        .trim() !== '' && !regexNoSpecial.test(input.value)) {
                        invalide(input, feedback, "Caractères spéciaux non autorisés.");
                        isValid = false;
                    }
                    if (input.type === 'number') {
                        const value = input.value.trim();
                        const number = Number(value);

                        if (value !== '') {
                            if (isNaN(number)) {
                                invalide(input, feedback, "Valeur non numérique.");
                                isValid = false;
                            } else if (number < 0) {
                                invalide(input, feedback,
                                    "Les nombres négatifs ne sont pas autorisés.");
                                isValid = false;
                            }
                        }
                    }
                    // Select requis
                    if (input.tagName.toLowerCase() === 'select' && input.required && input
                        .value === '') {
                        invalide(input, feedback, "Veuillez faire un choix.");
                        isValid = false;
                    }

                    // Date
                    if (input.type === 'date' && input.value !== '') {
                        const today = new Date();
                        const valueDate = new Date(input.value);
                        if (valueDate > today) {
                            invalide(input, feedback, "La date ne peut pas être dans le futur.");
                            isValid = false;
                        }
                    }

                    // Fichier image
                    if (input.type === 'file' && input.files[0]) {
                        const file = input.files[0];
                        if (!/\.(jpg|jpeg)$/i.test(file.name) || file.size > 2 * 1024 * 1024) {
                            invalide(input, feedback, "Fichier invalide.");
                            isValid = false;
                        }
                    }
                });

                if (!isValid) {
                    afficherEtape(1);
                    e.preventDefault();
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typePoste = {!! $jsTypePoste !!};
            const typeConsommable = {!! $jsTypeConsommable !!};

            const radio1 = document.getElementById('radio1');
            const radio2 = document.getElementById('radio2');
            const select = document.getElementById('typeSelect');
            const pcDiv = document.getElementById('pc');
            // Masqué par défaut
            pcDiv.style.display = "none";

            function updateSelectOptions(options) {
                // Vider les options existantes
                select.innerHTML = '<option value="">Choisir le type</option>';
                // Ajouter les nouvelles options
                options.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.textContent = option;
                    select.appendChild(opt);
                });
            }

            // Chargement initial
            updateSelectOptions(typePoste);

            // Quand le select change
            select.addEventListener('change', function() {
                const selectedType = this.value;

                if (selectedType === "Ordinateur portable") {
                    pcDiv.style.display = "block";
                } else {
                    pcDiv.style.display = "none";
                }
            });
            //toggleCodeInterne(true); // afficher par défaut car "poste" est coché
            toggleCodeInterne(false); //ne pas afficher le code interne par defaut
            // Écoute des changements sur les radios
            radio1.addEventListener('change', function() {
                if (this.checked) {
                    updateSelectOptions(typePoste);
                    // toggleCodeInterne(true);
                    toggleCodeInterne(false); // affiche code interne

                }
            });

            radio2.addEventListener('change', function() {
                if (this.checked) {
                    updateSelectOptions(typeConsommable);
                    toggleCodeInterne(false);
                }
            });
        });

        function toggleCodeInterne(show) {
            const codeInterneDiv = document.getElementById('codeInterneWrapper');
            const codeInterneInput = document.getElementById('code_interne');

            if (show) {
                codeInterneDiv.style.display = 'flex';
                codeInterneInput.required = true;
            } else {
                codeInterneDiv.style.display = 'none';
                codeInterneInput.required = false;
                codeInterneInput.value = '';
            }
        }
    </script>

@endsection
