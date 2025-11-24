@extends('layouts.dynamique')
@section('content')
    <div class="header">
        <i class="fa fa-home"></i>/ Maintenance Materiel

    </div>
    <div class="w3-panel">
        <h4 class="w3-start w3-animate-right">
            Traitement du ticket
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
                    <a href=""class="btn btn-success btn-round" data-toggle="modal"
                        data-target="#modal-creer-tache"><i class="fa fa-plus"></i> Creer Tache</a>
                    {{-- <a
                        href="{{ route('mouvement.liste', ['id_emplacement' => Auth::user()->id_emplacement, 'role' => Auth::user()->role]) }}"class="btn btn-success btn-round">Liste des tickets</a> --}}
                    <table class="table table-bordered table-hover table-responsive mt-2">
                        <thead>
                            <tr>
                                <th style="text-align: center">Numero Tache</th>
                                {{-- <th style="text-align: center">Nom Tache</th>
                                <th style="text-align: center">Description</th>
                                <th style="text-align: center">Status</th> --}}
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- modal materiel -->
    <div class="modal fade" id="modal-creer-tache">
        <div class="modal-dialog modal-lg">
            <div class="modal-content info">
                <div class="modal-header ">
                    <h4 class="modal-title text-primary">Creer Tache</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('materiel.ajout_materiel') }}" id="register-form"
                    enctype="multipart/form-data" onsubmit="return validateForm()" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body color-secondary text-white">
                        <input type="hidden" name='id_utilisateur' value="">
                        <div class="row mb-3">
                            <label for="nom_tache"
                                class="col-md-4 col-form-label text-md-end">{{ __('Titre du Tache :') }}</label>
                            <div class="col-md-6">
                                <input id="nom_tache" type="text"
                                    class="form-control @error('nom_tache') is-invalid @enderror" name="nom_tache"
                                    value="{{ old('nom_tache') }}" autocomplete="nom_tache" required>
                                <div class="invalid-feedback">Caractere interdit.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-end">{{ __('Description :') }}</label>
                            <div class="col-md-6">
                                <input id="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror" name="description"
                                    value="{{ old('description') }}" autocomplete="description">
                                <div class="invalid-feedback">Caractere interdit.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-outline-success">Terminer</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
