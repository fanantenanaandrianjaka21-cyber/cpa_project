@extends('layouts.dynamique')
@section('content')
    <div class="header">
        <i class="fa fa-home"></i>/ Stock / Mouvement

    </div>
    <div class="w3-panel">
        <h4 class="w3-start w3-animate-right">
            Mouvement de stock
        </h4>
    </div>
    <div class="card">
        <div class="card-body bg-primary text-black">
            <div class="row">
                <div class="col-12 ">
                    <div class="row">
                        <div class="col-md-2">
                            <a
                                href="{{ route('gestionMateriels', ['id_emplacement' => Auth::user()->id_emplacement, 'role' => Auth::user()->role]) }}"class="btn btn-success btn-round ">Liste
                                de Stock</a>
                        </div>
                        <div class="col-md-3">
                            <form method="POST" action="{{ route('mouvementexcel.export') }}">

                                @csrf

                                {{-- <input type="text" name="name" placeholder="Nom de fichier"> --}}
                                <button type="submit" class="btn btn-success btn-round">Export Excel</button>
                                <select name="extension">
                                    <option value="xlsx">.xlsx</option>
                                    <option value="csv">.csv</option>
                                </select>

                            </form>
                        </div>
                    </div>
                    <div id="filters" class="row mb-3"></div>
                    <table id="bootstrap-data-table-export"
                        class="table table-striped table-striped-bg-default table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Materiel</th>
                                <th>Quantite</th>
                                <th>Mouvement</th>
                                <th>Source</th>
                                <th>Destination</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mouvement as $mouvement)
                                <tr>
                                    <td>{{ $mouvement['id'] }}</td>
                                    <td class="text-center ">
                                        {{-- <img class="card-img-top"
                                            style="background-size: cover;min-height: 50px; max-height: 50px;max-width:100px"src="{{ asset('storage/' . $mouvement['image']) }}"><br> --}}
                                        {{ $mouvement['type'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $mouvement['quantite'] }}
                                    </td>
                                    @if ($mouvement['type_mouvement'] == 'entree')
                                        <td class="text-center w3-text-green">{{ $mouvement['type_mouvement'] }}</td>
                                    @else
                                        <td class="text-center" style="color: rgba(255, 0, 0, 0.7)">
                                            {{ $mouvement['type_mouvement'] }}</td>
                                    @endif

                                    <td>
                                        @if (empty($mouvement['source']))
                                            Achat
                                        @else
                                            {{ $mouvement['source'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($mouvement['type_mouvement'] == 'sortie')
                                            {{ $mouvement['prenom_utilisateur'] }}
                                        @else
                                            {{ $mouvement['destination'] }}
                                            {{-- soloina ny emplacement dans emplacements --}}
                                        @endif
                                    </td>
                                    <td>{{ $mouvement['date_mouvement'] }}</td>

                                    <td>

                                        <div class="text-center">
                                            {{-- <a href="#" class="btn btn-outline-info btn-xs" >Details</a> --}}
                                            <a href="#" class="btn btn-outline-danger btn-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Supprimer"><i class="fa fa-trash-o "></i></a>
                                        </div>
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
        <div class="modal-dialog">
            <div class="modal-content info">
                <div class="modal-header">
                    <h4 class="modal-title">Ajout d'un materiel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('materiel.ajout_materiel') }}" id="register-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div id="etape1">
                            <input type="hidden" name='id_utilisateur' value="">
                            <!-- alaina avy any anaty base -->
                            <div class="form-group row">
                                <label for="id_emplacement" id="id_emplacement"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Emplacement') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="id_emplacement"
                                        required>
                                        <option value="">Choisir emplacement de stock</option>
                                        @if (!empty($emplacement))
                                            @foreach ($emplacement as $emplacement)
                                                <option value="{{ $emplacement->id }}">{{ $emplacement->emplacement }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('id_emplacement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code_interne"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Code interne') }}</label>
                                <div class="col-md-6">
                                    <input id="code_interne" type="text"
                                        class="form-control @error('code_interne') is-invalid @enderror" name="code_interne"
                                        value="{{ old('code_interne') }}" required autocomplete="code_interne" autofocus>

                                    @error('code_interne')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="date_affectation"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Date d\'aquisition') }}</label>

                                <div class="col-md-6">
                                    <input id="date_aquisition" type="date"
                                        class="form-control @error('date_aquisition') is-invalid @enderror"
                                        name="date_aquisition" value="{{ old('date_aquisition') }}" required
                                        autocomplete="date_aquisition" autofocus>
                                    @error('date_aquisition')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="type"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Type du Materiel') }}</label>
                                <div class="col-md-6">
                                    <input id="type" type="text"
                                        class="form-control @error('type') is-invalid @enderror" name="type"
                                        value="{{ old('type') }}" required autocomplete="type" autofocus>

                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="marque"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Marque') }}</label>
                                <div class="col-md-6">
                                    <input id="marque" type="text"
                                        class="form-control @error('marque') is-invalid @enderror" name="marque"
                                        value="{{ old('marque') }}" required autocomplete="marque" autofocus>
                                    @error('marque')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="model"
                                    class="col-md-4 col-form-label text-md-end">{{ __('model') }}</label>
                                <div class="col-md-6">
                                    <input id="model" type="text"
                                        class="form-control @error('model') is-invalid @enderror" name="model"
                                        value="{{ old('model') }}" required autocomplete="model" autofocus>
                                    @error('model')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="serie"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Numero de Serie') }}</label>
                                <div class="col-md-6">
                                    <input id="num_serie" type="text"
                                        class="form-control @error('num_serie') is-invalid @enderror" name="num_serie"
                                        value="{{ old('num_serie') }}" required>
                                    @error('num_serie')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <input id="status" type="hidden" name="status" value="disponible">
                            <div class="row mb-3">
                                <label for="image" class="col-md-4 col-form-label text-md-end">Image :</label>
                                <div class="col-md-6">
                                    <input class="form-control-file border" type="file" name="image" />
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="etape2" style="display: none;">
                            <h5>Champs suplemantaire</h5>
                            <div id="champs">
                                <div id="champs-pair">

                                </div>
                            </div>
                            <button type="button" onclick="ajouterChamp()">➕ Ajouter plus de
                                caracteristque</button><br><br>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        <button type="button" id="btn-precedent" class="btn btn-secondary" style="display:none;"
                            onclick="afficherEtape(1)">← Précédent</button>
                        <button type="button" id="btn-suivant" class="btn btn-primary"
                            onclick="afficherEtape(2)">Suivant →</button>
                        <button type="submit" class="btn btn-success">Terminer</button>
                        <!-- <button type="submit" id="btn-enregistrer" class="btn btn-success" style="display:none;">Terminerf</button> -->
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
                <label class="col-md-2 col-form-label text-md-end">Clé</label>
                <div class="col-md-4">
                    <input type="text" name="cles[]" class="form-control" required>
                </div>
                <label class="col-md-2 col-form-label text-md-end">Valeur</label>
                <div class="col-md-4">
                    <input type="text" name="valeurs[]" class="form-control" required>
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

@endsection
