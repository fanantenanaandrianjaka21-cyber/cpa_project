@extends('layouts.dynamique')
@section('content')
    @if (!empty($user))
        <div class="header d-none d-lg-block">
            <i class="fa fa-home"></i>/ Utilisateur / Liste

        </div>
        <div class="w3-panel w3-pale-blue w3-bottombar w3-border-blue w3-border">
            <h4 class="w3-start w3-animate-right">
                Liste des Utilisateurs
            </h4>
        </div>
        <div class="card ">
            <div class="card-body bg-primary text-white">

                <div class="row">
                    <div class="col-12">
                        <?php
                        if (isset($notification)) {
                            echo "<div class='alert alert-success'>
                                                                                                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                                                                                      <i class='fa fa-close'></i>
                                                                                                                    </button>
                                                                                                                    <span>
                                                                                                                      <i class='fa fa-bell'></i><b>  Success - </b>" .
                                $notification .
                                "</span>
                                                                                                                  </div>";
                        }
                        ?>
<p>Sélectionnez un fichier Excel (.xlsx) pour importer une liste des "utilisateurs".<br>

                        <form method="POST" action="{{ route('utilisateurexcel.import') }}">

                            @csrf

                            <input type="file" name="fichier">


                            <button type="submit" class="btn btn-success">Importer</button>
                        </form>
                        <div id="filters" class="row mb-3"></div>
                        <table id="bootstrap-data-table-export"
                            class="display nowrap table table-hover table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Equipe</th>
                                    <th>Societe</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $user)
                                    <tr data-row-id="{{ $user->id }}">
                                        <td>{{ $user->nom_utilisateur }}</td>
                                        <td>{{ $user->equipe }}</td>
                                        <td>{{ $user->societe }}</td>
                                        <td>
                                            <div class="pull-right hidden-phone">
                                                <a href="{{ route('utilisateur.details', $user->id) }}"
                                                    class="btn btn btn-outline-info btn-xs">Details</a>
                                                <a href="{{ route('utilisateur.edit', $user->id) }}"
                                                    class="btn btn-outline-secondary btn-xs" data-toggle="tooltip"
                                                    data-placement="top" title="Modifier"><i class="fa fa-pencil"></i></a>
                                                <button type="button" class="btn btn-outline-danger deleteBtn"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer"
                                                    data-id="{{ $user->id }}">
                                                    <i class="fa fa-trash-o "></i>
                                                </button>
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
        {{-- modal --}}
        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmation du suppression</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body bg-primary text-warning">
                        <p><i class="fa fa-warning"></i> Tous les donnees
                            de cet utilisateur seront aussi supprimer definitivement</p>
                    </div>
                    <div class="modal-footer footer bg-primary">
                        <button id="confirmDelete" class="btn btn-outline-success">Confirmer</button>
                        <button class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
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

                const url = '/deleteUtilisateur/' + encodeURIComponent(currentId);
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

                        content.message = 'Utilisateur supprimé avec succès';
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
