@extends('layouts.dynamique')
@section('content')
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

    @if (!empty($user))
        <div class="header d-none d-lg-block">
            <i class="fa fa-home"></i>/ Utilisateur / Liste

        </div>
        <div class="w3-panel">
            <h4 class="w3-start w3-animate-right">
                Liste des Utilisateurs
            </h4>
        </div>
        <div class="card ">
            <div class="card-body bg-primary text-black">

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
                        <p class="text-black">Sélectionnez le fichier Excel (Mouvement materiel.xlsx) pour importer une
                            liste des
                            "utilisateurs".<br>
                            {{-- nouveau import --}}
                        <form id="form_import" method="POST" action="{{ route('utilisateurexcel.import') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex align-items-center gap-4">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="file" name="fichier" class="form-control" required>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-success">Importer</button>
                                </div>
                            </div>
                        </form>








                        {{-- fin nouveau import --}}

                        {{-- <form method="POST" action="{{ route('utilisateurexcel.import') }}" enctype="multipart/form-data">

                            @csrf
                            <div class="d-flex align-items-center gap-4">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="file" name="fichier" class="form-control">
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-success">Importer</button>
                                </div>
                            </div>
                        </form> --}}

                        <div id="filters" class="row mb-3"></div>
                        <table id="bootstrap-data-table-export"
                            class="display nowrap table table-hover table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom</th>
                                    <th>Equipe</th>
                                    <th>Societe</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $user)
                                    <tr data-row-id="{{ $user->id }}">
                                        <td>{{ $user->id }}</td>
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
                    <div class="modal-footer footer">
                        <button id="confirmDelete" class="btn btn-outline-success">Confirmer</button>
                        <button class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        {{-- modal progression --}}
<!-- Modal Progression Améliorée -->
<div class="modal fade" id="progressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl"><!-- plus large -->
        <div class="modal-content p-3 position-relative">

            <!-- Bouton close -->
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close">
            </button>

            <h5 class="mb-3">Import de la liste des utilisateurs en cours...</h5>
            
            <!-- Progression -->
            <div id="progressText">0 / 0 lignes dans le fichier</div>
            <div class="progress my-3">
                <div id="progressBar" class="progress-bar" role="progressbar" style="width:0%">0%</div>
            </div>

            <!-- Résumé importé / non importé -->
            <div id="importSummary" class="mb-3"></div>

            <!-- Doublons -->
            <div id="doublonsContainer" class="mt-3" style="display:none;">
                <h6 class="fw-bold text-warning d-flex align-items-center">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    Utilisateurs déjà existants
                    <span id="doublonsBadge" class="badge bg-warning ms-2 text-dark">0</span>
                </h6>
                <ul id="doublonsList" class="list-group" style="max-height:250px; overflow-y:auto;"></ul>
            </div>

            <!-- Lignes non importées -->
            <div id="failedContainer" class="mt-3" style="display:none;">
                <h6 class="fw-bold text-danger d-flex align-items-center">
                    <i class="fa fa-times-circle me-2"></i>
                    Lignes non importées
                    <span id="failedBadge" class="badge bg-danger ms-2">0</span>
                </h6>
                <ul id="failedList" class="list-group" style="max-height:250px; overflow-y:auto;"></ul>
            </div>

        </div>
    </div>
</div>

        {{-- fin modal progression --}}
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

        <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
    $('#form_import').on('submit', async function(e) {
    e.preventDefault();

    // 🔹 Réinitialisation du modal
    $('#doublonsList').empty();
    $('#failedList').empty();
    $('#doublonsContainer').hide();
    $('#failedContainer').hide();
    $('#doublonsBadge').text("0");
    $('#failedBadge').text("0");
    $('#progressBar').css('width','0%').text('0%');

    let fileInput = $(this).find('input[name="fichier"]')[0];
    if(fileInput.files.length === 0){
        alert("Sélectionnez un fichier !");
        return;
    }

    let file = fileInput.files[0];
    let data = await file.arrayBuffer();
    let workbook = XLSX.read(data);
    let sheet = workbook.Sheets['utilisateurs_articles'];
    if(!sheet){
        alert("Feuille 'utilisateurs_articles' introuvable !");
        return;
    }

    let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });
    let headerRow = 1; // ligne 2
    let headers = jsonData[headerRow];
    let dataRows = jsonData.slice(headerRow + 1).filter(r => r.length > 0);
    let totalLines = dataRows.length;

    $('#progressModal').modal('show');
    $('#progressText').text(`0 / ${totalLines} lignes importées`);
    $('#progressBar').css('width','0%').text('0%');

    let chunkSize = 10;
    let totalImported = 0;
    let totalAlreadyExists = 0;
    let totalFailed = 0;

    for (let i = 0; i < totalLines; i += chunkSize) {
        let chunk = dataRows.slice(i, i + chunkSize);

        let chunkData = chunk.map(row => {
            let obj = {};
            headers.forEach((h, idx) => {
                let key = h.toLowerCase()
                            .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
                            .replace(/[^a-z0-9]/g,'_');
                obj[key] = row[idx] ?? null;
            });
            return obj;
        });

        try {
            let res = await $.ajax({
                url: "{{ route('utilisateurexcel.import') }}",
                type: "POST",
                contentType: 'application/json',
                processData: false,
                data: JSON.stringify({ data: chunkData }),
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            totalImported += res.total_imported;
            totalAlreadyExists += res.total_already_exists;
            totalFailed += res.total_failed;

            // Mise à jour progression
            let percent = Math.floor((i + chunk.length) / totalLines * 100);
            $('#progressBar').css('width', percent + '%').text(percent + '%');
            $('#progressText').html(`
                Total lignes fichier: ${totalLines} <br>
                Total importé: ${totalImported} <br>
                Doublons: ${totalAlreadyExists} <br>
                Non importé: ${totalFailed}
            `);

            // Affichage doublons et échecs partiels
            if(res.already_exists.length > 0){
                $('#doublonsContainer').show();
                $('#doublonsBadge').text(totalAlreadyExists);
                res.already_exists.forEach(name => {
                    $('#doublonsList').append(`<li class="list-group-item list-group-item-warning">${name}</li>`);
                });
            }

            if(res.failed.length > 0){
                $('#failedContainer').show();
                $('#failedBadge').text(totalFailed);
                res.failed.forEach(name => {
                    $('#failedList').append(`<li class="list-group-item list-group-item-danger">${name}</li>`);
                });
            }

        } catch(err) {
            console.error("Erreur lors de l'import d'un chunk :", err);
            alert("Erreur lors de l'import, voir console pour détails.");
            break;
        }
    }

    $('#progressBar').css('width','100%').text('100%');
});
$('#progressModal').on('hidden.bs.modal', function () {
    location.reload(); // recharge la page
});

</script>


    @endif
@endsection
