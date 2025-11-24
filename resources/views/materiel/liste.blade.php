@extends('layouts.dynamique')

@section('content')
    <div class="header">
        <i class="fa fa-home"></i>/ Materiels / Tous les Materiels

    </div>
    <div class="w3-panel">
        
            @if( Auth::User()->role == "Utilisateur")
            
                <h4 class="w3-start w3-animate-right">Liste de tous mes Matériels</h4>
                
            
            @else
            
                <h4 class="w3-start w3-animate-right">Liste de tous les Matériels</h4>
                
            @endif
            
        
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

                    <div id="filters" class="row mb-3"></div>
                    <div class="row mb-2">
                        <div class="d-flex align-items-center gap-3">

                            <div id="totalSelectionnes" class="text-black">
                                0 Materiel sélectionné(s)
                            </div>

                            <div id="bouton-distribuer-container" style="display: none;">
                                <button id="btn-distribuer" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalDistribuer">
                                    <i class="fa fa-share"></i> Distribuer
                                </button>
                            </div>

                        </div>
                    </div>

                    <table id="bootstrap-data-table-export" class="table table-hover table-responsive">

                        <thead>
                            <tr>
                                <th class="text-center"><input class="form-check-input bg-secondary checkbox-materiel"
                                        type="checkbox" id="tous" value="tous"> Tous</th>
                                <th>Id</th>
                                <th>Materiel</th>
                                <th>Marque</th>
                                <th>Localisation</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{ dd($detail_materiel) }} --}}
                            @foreach ($detail_materiel as $materiel)
                                <tr data-row-id="{{ $materiel['id'] }}">
                                    <td class="text-center"><input class="form-check-input bg-secondary checkbox-materiel"
                                            type="checkbox" id="option1" value="{{ $materiel['id'] }}"></td>
                                    <td>{{ $materiel['id'] }}</td>
                                    <td class="text-center">
                                        {{ $materiel['type'] }}
                                    </td>
                                    <td class="text-center">{{ $materiel['marque'] ?? '--' }}</td>
                                    <td>
                                        <a href="/localisation/{{ $materiel['id_emplacement'] }}"
                                            data-value="{{ $materiel['emplacement'] }}">
                                            {{ $materiel['emplacement'] }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if ($materiel['status'] == 'disponible')
                                            <span
                                                style="background-color:rgba(0, 128, 0, 0.603);color:white;border-radius:10px;padding:5px;">{{ $materiel['status'] }}</span>
                                        @elseif ($materiel['status'] == 'utiliser')
                                            <span
                                                style="background-color:rgba(35, 240, 213, 0.74);color:white;border-radius:10px;padding:5px">{{ $materiel['status'] }}</span><br><br>
                                            {{-- par {{ $materiel['nom_utilisateur'] }}<br>{{ $materiel['societe'] }}, equipe
                                            {{ $materiel['equipe'] }} --}}
                                        @else
                                            <span
                                                style="background-color:rgba(240, 192, 35, 0.74);color:white;border-radius:10px;padding:5px">{{ $materiel['status'] }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="pull-right hidden-phone">
                                            <a href="{{ route('caracteristique.voir', ['id' => $materiel['id'], 'page' => 'materiel']) }}"
                                                class="btn btn-outline-info btn-xs">Details</a>
                                            <a href="{{ route('materiel.edit', $materiel['id']) }}"
                                                class="btn btn-outline-secondary btn-xs" data-toggle="tooltip"
                                                data-placement="top" title="Modifier"><i class="fa fa-pencil"></i></a>
                                            {{-- <a href="{{ route('materiel.delete', $materiel['id']) }}"
                                                class="btn btn-outline-danger btn-xs" data-toggle="tooltip"
                                                data-placement="top" title="Supprimer"><i class="fa fa-trash-o "></i></a> --}}
                                            <button type="button" class="btn btn-outline-danger deleteBtn"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer"
                                                data-id="{{ $materiel['id'] }}">
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
    {{-- modal distribuer --}}
    {{-- <div class="modal fade" id="modalDistribuer" tabindex="-1" aria-labelledby="modalDistribuerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDistribuerLabel">
                    <i class="fa fa-share"></i> Matériels sélectionnés
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="liste-ids" class="fw-bold text-center text-secondary"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success" id="confirmer-distribution">
                    Confirmer la distribution
                </button>
            </div>
        </div>
    </div>
</div> --}}

    <!-- ✅ Modal Bootstrap pour distribution -->
    <div class="modal fade" id="modalDistribuer" tabindex="-1" aria-labelledby="modalDistribuerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalDistribuerLabel">
                        <i class="fa fa-share"></i> Distribuer les matériels
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- <div class="mb-3 text-center">
                    <p class="fw-bold">Matériels sélectionnés :</p>
                    <div id="liste-ids" class="alert alert-light"></div>
                </div> --}}

                    <div class="mb-3">
                        <label for="select-emplacement" class="form-label fw-bold">Choisir un emplacement :</label>
                        <select id="select-emplacement" class="form-select">
                            <option value="">-- Sélectionnez --</option>
                            <option value="2">ANTSIRABE</option>
                            <option value="3">BNI</option>
                            <option value="4">MADAFIT</option>
                            <option value="5">CENTRE</option>
                            <option value="6">MATURA</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success" id="btn-effectuer">Effectuer</button>
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
                        de ce materiel seront aussi supprimer definitivement</p>
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

            const url = '/deleteMateriels/' + encodeURIComponent(currentId);
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

                    content.message = 'Materiel supprimé avec succès';
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
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const boutonDistribuer = document.getElementById('bouton-distribuer-container');
        //     const checkboxes = document.querySelectorAll('.checkbox-materiel');
        //     const selectAll = document.getElementById('tous');

        //     function toggleBoutonDistribuer() {
        //         const auMoinsUnCoche = Array.from(checkboxes).some(cb => cb.checked);
        //         boutonDistribuer.style.display = auMoinsUnCoche ? 'block' : 'none';
        //     }

        //     // Quand une case individuelle change
        //     checkboxes.forEach(cb => cb.addEventListener('change', toggleBoutonDistribuer));

        //     // Quand on coche "Tous"
        //     if (selectAll) {
        //         selectAll.addEventListener('change', function() {
        //             checkboxes.forEach(cb => cb.checked = selectAll.checked);
        //             toggleBoutonDistribuer();
        //         });
        //     }
        // });

        document.addEventListener('DOMContentLoaded', function() {
            const boutonDistribuerContainer = document.getElementById('bouton-distribuer-container');
            const boutonDistribuer = document.getElementById('btn-distribuer');
            const checkboxes = document.querySelectorAll('.checkbox-materiel');
            const selectAll = document.getElementById('tous');
            const listeIds = document.getElementById('liste-ids');
            const btnEffectuer = document.getElementById('btn-effectuer');
            const selectEmplacement = document.getElementById('select-emplacement');

            function toggleBoutonDistribuer() {
                const auMoinsUnCoche = Array.from(checkboxes).some(cb => cb.checked);
                boutonDistribuerContainer.style.display = auMoinsUnCoche ? 'block' : 'none';
            }

            checkboxes.forEach(cb => cb.addEventListener('change', toggleBoutonDistribuer));

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    toggleBoutonDistribuer();
                });
            }

            // ✅ Ouvrir le modal et afficher les IDs cochés
            boutonDistribuer.addEventListener('click', function() {
                const idsSelectionnes = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (idsSelectionnes.length === 0) {
                    listeIds.innerHTML = `<span class="text-danger">Aucun matériel sélectionné.</span>`;
                } else {
                    listeIds.innerHTML = idsSelectionnes.map(id => `
                <span class="badge bg-secondary m-1">${id}</span>
            `).join('');
                }
            });

            // ✅ Envoi vers Laravel au clic sur Effectuer
            btnEffectuer.addEventListener('click', function() {
                const idsSelectionnes = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                const idEmplacement = selectEmplacement.value;

                if (idsSelectionnes.length === 0) {
                    alert("Veuillez sélectionner au moins un matériel !");
                    return;
                }
                // else{
                //                 alert("Taille "+idsSelectionnes.length);
                //     return;
                // }

                if (!idEmplacement) {
                    alert("Veuillez choisir un emplacement !");
                    return;
                }

                // ✅ Appel AJAX vers Laravel
                fetch('/materiels/distribuer', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            ids: idsSelectionnes,
                            id_emplacement: idEmplacement
                        })
                    })
                    .then(async res => {
                        if (res.ok) {
                            alert("Distribution effectuée avec succès !");
                            location.reload(); // rafraîchir la page
                        } else {
                            let data = await res.json();
                            alert("Erreur : " + data.message);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Erreur réseau !");
                    });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const boutonDistribuerContainer = document.getElementById('bouton-distribuer-container');
            const boutonDistribuer = document.getElementById('btn-distribuer');
            const checkboxes = document.querySelectorAll('.checkbox-materiel');
            const selectAll = document.getElementById('tous');
            const listeIds = document.getElementById('liste-ids');
            const confirmerBtn = document.getElementById('confirmer-distribution');
            // ✅ Fonction pour afficher / cacher le bouton Distribuer
            function toggleBoutonDistribuer() {
                const auMoinsUnCoche = Array.from(checkboxes).some(cb => cb.checked);
                const nbrsSelectionnes = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value).length;
                document.getElementById('totalSelectionnes').innerText =
                    nbrsSelectionnes + " Materiel sélectionné(s)";
                // alert(nbrsSelectionnes);
                boutonDistribuerContainer.style.display = auMoinsUnCoche ? 'block' : 'none';
            }

            // ✅ Quand on coche / décoche une case individuelle
            checkboxes.forEach(cb => cb.addEventListener('change', toggleBoutonDistribuer));

            // ✅ Quand on coche / décoche "Tous"
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    toggleBoutonDistribuer();
                });
            }

            // ✅ Quand on ouvre le modal (au clic sur "Distribuer")
            boutonDistribuer.addEventListener('click', function() {
                const idsSelectionnes = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (idsSelectionnes.length === 0) {
                    listeIds.innerHTML = `<span class="text-danger">Aucun matériel sélectionné.</span>`;
                } else {
                    listeIds.innerHTML = `
                <div class="alert alert-light">
                    ${idsSelectionnes.map(id => `<span class="badge bg-secondary m-1">${id}</span>`).join('')}
                </div>
            `;
                }
            });

            // ✅ (Optionnel) Si tu veux une action sur "Confirmer la distribution"
            confirmerBtn.addEventListener('click', function() {
                const idsSelectionnes = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                console.log("Liste des IDs à distribuer :", idsSelectionnes);

                // Exemple d’envoi vers Laravel :
                /*
                fetch('/distribuer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ ids: idsSelectionnes })
                })
                .then(res => res.json())
                .then(data => {
                    alert('Distribution réussie !');
                    location.reload(); // recharger la page si besoin
                });
                */
            });
        });
    </script>
@endsection
