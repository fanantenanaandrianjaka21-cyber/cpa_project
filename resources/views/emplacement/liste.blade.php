@extends('layouts.dynamique')
@section('content')


    @if (!empty($emplacement))
       <div class="header">
        <i class="fa fa-home"></i>/ Emplacement / Liste

    </div>
        <div class="card">
            <div class="card-header">
                <h7>Liste des Emplacements</h7>
            </div>
            {{-- <button id="darkModeToggle" class="btn btn-outline-secondary">
  🌙 Mode Sombre
</button> --}}

            <div class="card-body">

                <div class="row">
                    <div class="col-12">
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

                        <table id="bootstrap-data-table-export" class="table table-hover table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    {{-- <th>Code_emplacement</th> --}}
                                    <th>Emplacement</th>
                                    {{-- <th>code_final</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emplacement as $emplacement)
                                    <tr data-row-id="{{ $emplacement->id }}">
                                        <td> {{ $emplacement->id }} </td>
                                        {{-- <td> {{ $emplacement->code_emplacement }} </td> --}}
                                        <td class="text-center"><a href="/localisation/ {{ $emplacement->id }} "> {{ $emplacement->emplacement }}
                                            </a></td>
                                        {{-- <td> {{ $emplacement->code_final }} </td> --}}

                                        <td>
                                            <div class="text-center">
                                                <a href="{{ route('emplacement.details', $emplacement->id) }}"
                                                    class="btn btn-info btn-xs">Details</i></a>
                                                <a href="{{ route('emplacement.edit', $emplacement->id) }}"
                                                    class="btn btn-secondary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <button type="button" class="btn btn-danger deleteBtn"
                                                    data-id="{{ $emplacement->id }}">
                                                    <i class="fa fa-trash-o "></i>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                    {{-- modal --}}
                                    <div class="modal fade" id="deleteModal">
                                        <!-- mbola reglage -->
                                        <div class="modal-dialog">
                                            <!-- modal-content manao border radius -->
                                            <!-- bg-primary lokon'ny background -->
                                            <div class="modal-content bgcolor">
                                                <!-- modal-header reglage ny header,manisy tsipika -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirmation du suppression</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <!-- &times; icone crois kely -->
                                                        <span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <!-- le corps du modal -->
                                                <div class="modal-body">
                                                    <!-- &hellip icone 3points -->
                                                    <p>Voullez vous vraiment supprimer cet emplacement?Tous les donnees
                                                        relatifs à cet emplacement seront aussi supprimer definitivement</p>
                                                </div>
                                                <!-- justify-content-between manasaraka an'ilay boutton==>lasa responsive -->
                                                <div class="modal-footer footer">
                                                    <!-- data-dismiss=modal manala an'ilay modal -->
                                                    <button id="confirmDelete" class="btn btn-success">Confirmer</button>
                                                    <button class="btn btn-primary" data-dismiss="modal">Annuler</button>


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
        {{-- dark mode --}}
        <script>
            const toggleBtn = document.getElementById("darkModeToggle");
            const body = document.body;

            // Vérifier si le mode sombre est déjà activé (sauvegarde dans localStorage)
            if (localStorage.getItem("theme") === "dark") {
                body.classList.add("dark-mode");
                toggleBtn.textContent = "☀️ Mode Clair";
            }

            toggleBtn.addEventListener("click", () => {
                body.classList.toggle("dark-mode");

                if (body.classList.contains("dark-mode")) {
                    toggleBtn.textContent = "☀️ Mode Clair";
                    localStorage.setItem("theme", "dark");
                } else {
                    toggleBtn.textContent = "🌙 Mode Sombre";
                    localStorage.setItem("theme", "light");
                }
            });
        </script>
    @else
        <h1>hafa</h1>
    @endif
@endsection
