@extends('layouts.dynamique')
@section('content')
    @if (!empty($Ticket))
        <div class="header d-none d-lg-block">
            <i class="fa fa-home"></i>/ Tickets / Liste

        </div>
        <div class="w3-panel">
            <h4 class="w3-start w3-animate-right">
                Liste des Tickets
            </h4>
        </div>
        <div class="card">
            <div class="card-body bg-primary text-white">

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
                        if (isset($notification)) {
                            echo "<div class='alert alert-success shadow-lg'>
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
                        <div id="filters" class="row mb-3"></div>
                        <table id="bootstrap-data-table-export" class="table table-hover table-responsive ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    {{-- <th>Demandeur</th> --}}
                                    <th>Ticket</th>
                                    <th>Priorite</th>
                                    <th>Statut</th>
                                    <th>Technicien</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Ticket as $Ticket)
                                    <tr data-row-id="{{ $Ticket->id }}">
                                        <td class="text-center"> {{ $Ticket->id }} </td>
                                        {{-- <td class="text-center">
                                            {{ $Ticket->utilisateur->nom_utilisateur }}
                                        </td> --}}
                                        <td class="text-center">
                                            {{ $Ticket->objet }}
                                        </td>
                                        <td class="text-center" style="color: {{ $Ticket->priorite->color() }}">
                                            <span class="badge"
                                                style="background-color: {{ $Ticket->priorite->color() }};">

                                            </span>
                                            {{ $Ticket->priorite->label() }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge" style="background-color: {{ $Ticket->statut->color() }}">
                                                {{ $Ticket->statut->label() }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($Ticket->assignement)
                                                {{ $Ticket->technicien->nom_utilisateur }}
                                            @endif

                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <a href="{{ route('Ticket.details', $Ticket->id) }}"
                                                    class="btn btn-outline-info btn-xs">Details</i></a>
                                                <a href="{{ route('Ticket.edit', $Ticket->id) }}"
                                                    class="btn btn-outline-secondary btn-xs" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Modifier"><i
                                                        class="fa fa-pencil"></i></a>
                                                <button type="button" class="btn btn-outline-danger deleteBtn"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer"
                                                    data-id="{{ $Ticket->id }}">
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
                                                        relatifs à cet Ticket seront aussi supprimer definitivement</p>
                                                </div>
                                                <div class="modal-footer footer bg-primary">
                                                    <button id="confirmDelete"
                                                        class="btn btn-outline-success">Confirmer</button>
                                                    <button class="btn btn-outline-primary"
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

                const url = '/deleteTicket/' + encodeURIComponent(currentId);
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

                        content.message = 'Ticket supprimé avec succès';
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
