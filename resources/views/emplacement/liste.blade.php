@extends('layouts.dynamique')
@section('content')
    @if (!empty($emplacement))
        <div class="header d-none d-lg-block">
            <i class="fa fa-home"></i>/ Locale / Liste

        </div>
        <div class="w3-panel">
            <h4 class="w3-start w3-animate-right">
                Liste des Locales
            </h4>
        </div>
        <div class="card">

            <div class="card-body bg-primary text-white">

                <div class="row">
                    <div class="col-12">
                        <?php
                        if (isset($notification)) {
                            echo "<div class='alert alert-success shadow-lg fade show'>
                                                                                                                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                                                                                                              <i class='fa fa-close'></i>
                                                                                                                                            </button>
                                                                                                                                            <span>
                                                                                                                                              <b><i class='fa fa-bell'></i>  Success - </b>" .
                                $notification .
                                "</span>
                                                                                                                                          </div>";
                        }
                        ?>
                        <div class="d-flex">
                            <a href=""class="btn btn-success btn-round h-25" data-toggle="modal"
                                data-target="#modal-locale"><i class="fa fa-plus"></i> Locale</a>
                            <div id="filters" class="row mb-3 flex-fill"></div>
                        </div>

                        <table id="bootstrap-data-table-export" class="table table-hover table-responsive ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Code Locale</th>
                                    <th>Emplacement</th>
                                    {{-- <th>code_final</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emplacement as $emplacement)
                                    <tr data-row-id="{{ $emplacement->id }}">
                                        <td class="text-center"> {{ $emplacement->id }} </td>
                                        <td class="text-center"> {{ $emplacement->code_emplacement }} </td>
                                        <td class="text-center"><a href="/localisation/ {{ $emplacement->id }} ">
                                                {{ $emplacement->emplacement }}
                                            </a></td>
                                        {{-- <td> {{ $emplacement->code_final }} </td> --}}

                                        <td>
                                            <div class="text-center">
                                                <a href="{{ route('emplacement.details', $emplacement->id) }}"
                                                    class="btn btn-outline-info btn-xs">Details</i></a>
                                                <a href="{{ route('emplacement.edit', $emplacement->id) }}"
                                                    class="btn btn-outline-secondary btn-xs" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Modifier"><i
                                                        class="fa fa-pencil"></i></a>
                                                <button type="button" class="btn btn-outline-danger deleteBtn"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer"
                                                    data-id="{{ $emplacement->id }}">
                                                    <i class="fa fa-trash-o "></i>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                    {{-- modal --}}
                                    <div class="modal fade" id="deleteModal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirmation du suppression</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body bg-primary text-warning">
                                                    <p><i class="fa fa-warning"></i> Tous les donnees
                                                        relatifs à cet emplacement seront aussi supprimer definitivement</p>
                                                </div>
                                                <div class="modal-footer footer">
                                                    <button id="confirmDelete"
                                                        class="btn btn-success">Confirmer</button>
                                                    <button class="btn btn-primary"
                                                        data-dismiss="modal">Annuler</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
        {{-- modal locale --}}
        <div class="modal" id="modal-locale">
            <div class="modal-dialog modal-lg w3-animate-right">
                <div class="modal-content info ">
                    <div class="modal-header ">
                        <h4 class="modal-title text-primary">Ajout d'un materiel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-primary text-white">
                        <form method="POST" action="{{ route('emplacement.ajout') }}" id="register-form"
                            onsubmit="return validateForm()" class="needs-validation" novalidate>
                            @csrf
                            <div class="row mb-3">
                                <label for="emplacement"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Locale :') }}</label>
                                <div class="col-md-6">
                                    <input id="emplacement" type="text"
                                        class="form-control  @error('emplacement') is-invalid @enderror" name="emplacement"
                                        value="{{ old('emplacement') }}" required>
                                    <div class="invalid-feedback">Nom Locale invalide.</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code_emplacement"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Code Locale :') }}</label>
                                <div class="col-md-6">
                                    <input id="code_emplacement" type="text"
                                        class="form-control  @error('code_emplacement') is-invalid @enderror"
                                        name="code_emplacement" value="{{ old('code_emplacement') }}" required>
                                    <div class="invalid-feedback">Code Locale invalide.</div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Enregistrer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        {{-- fin modal locale --}}
        <script>
            let currentId = null;

            // Quand on clique sur un bouton "Supprimer"
            document.querySelectorAll('.deleteBtn').forEach(button => {
                button.addEventListener('click', function() {
                    currentId = this.dataset.id;

                    // Ouvre le modal (si Bootstrap 5)
                    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    modal.show();

                    // Stocke le modal dans une variable globale pour le fermer plus tard
                    window.currentModal = modal;
                });
            });

            // Quand on confirme la suppression dans le modal
            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (!currentId) return;

                const url = '/deleteEmplacement/' + encodeURIComponent(currentId);
                const xhttp = new XMLHttpRequest();

                xhttp.onload = function() {
                    if (xhttp.status === 200) {
                        // Fermer le modal
                        if (window.currentModal) {
                            window.currentModal.hide();
                        }

                        // Supprimer l'élément du DOM (optionnel si tu veux éviter le reload)
                        const row = document.querySelector(`[data-row-id="${currentId}"]`);
                        if (row) row.remove();
                        var content = {};

                        content.message = 'Emplacement supprimé avec succès';
                        content.icon = 'fa fa-bell';
                        // content.url = 'index.html';
                        // content.target = '_blank';

                        $.notify(content, {
                            type: 'success',
                            placement: {
                                from: 'top',
                                align: 'center'
                            },
                            time: 1000,
                        });
                        // Réinitialiser currentId
                        currentId = null;
                    } else {
                        var content = {};

                        content.message = 'Erreur lors de la suppression';
                        content.icon = 'fa fa-bell';
                        // content.url = 'index.html';
                        // content.target = '_blank';

                        $.notify(content, {
                            type: 'danger',
                            placement: {
                                from: 'top',
                                align: 'center'
                            },
                            time: 1000,
                        });
                    }
                };

                xhttp.onerror = function() {
                    alert("Erreur réseau.");
                };

                xhttp.open('GET', url, true);
                xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhttp.send();
            });
        </script>
    @endif
@endsection
