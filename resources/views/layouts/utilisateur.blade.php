<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Expert CPA', 'Expert CPA') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/w3.css') }}">
    <link rel="stylesheet" href="{{ asset('css/w3pro.css') }}">
    <link rel="stylesheet" href="{{ asset('css/w3colors.css') }}">
    <link rel="stylesheet" rel="stylesheet" href="{{ asset('css/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('datatable/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"> --}}
    <script src="{{ asset('datatable/vendors/chart.js/dist/Chart.min.js') }}"></script>

    {{-- datatable --}}
    <!-- ✅ DataTables CSS et Buttons en ligne -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
    <!-- ✅ jQuery et Bootstrap JS en ligne -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}

    <!-- ✅ DataTables et Buttons JS en ligne -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <style>
        #filters {
            text-align: end;
            justify-content: flex-end;
        }

        #filters a {
            margin-right: 8px;
            cursor: pointer;
            text-decoration: none;

        }

        #filters a.active {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar ">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- <img src="{{ asset('asset/logocpa.png') }}" style="height:50px;width: auto;" alt="Logo cpa"> --}}
                    <h2 class="expertcpa"><i class="fa fa-user-edit me-2"></i>Expert CPA</h2>
                </a>
                <?php
                $active_tab = $active_tab ?? 'ticket';
                if (request()->has('active_tab')) {
                    $active_tab = request('active_tab');
                }
                
                ?>
                <div class="navbar-nav w-100">
                    <!-- active -->
                    <a href="{{ route('dashboard') }}"
                        class="nav-item nav-link {{ $active_tab == 'dashboard' ? 'active' : '' }}"><i
                            class="fa fa-tachometer"></i>Accueil</a>
                    <a href="{{ route('tousLesMateriels', ['id_emplacement' => Auth::user()->id_emplacement, 'role' => Auth::user()->role]) }}"
                        class="nav-item nav-link {{ $active_tab == 'materiel' ? 'active' : '' }}"><i
                            class="fa fa-laptop me-2"></i>Materiels</a>

                    <a href="{{ route('listeTicketUtilisateur') }}"
                        class="nav-item nav-link {{ $active_tab == 'ticket' ? 'active' : '' }}"><i
                            class="fa fa-table me-2"></i>Ticketing</a>

                                        {{-- <a href="{{ route('listTicketAdmin') }}"
                        class="nav-item nav-link {{ $active_tab == 'ticket' ? 'active' : '' }}"><i
                            class="fa fa-user me-2"></i>Developpeurs</a> --}}
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            {{-- <nav class="navbar navbar-expand bg-info sticky-top px-4 py-0"> --}}
            <nav class="navbar navbar-expand sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                <div class="navbar-nav align-items-center ms-auto">
                    {{-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link" data-bs-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                            <span class="d-none d-lg-inline-flex ">Notification</span>


                            <div id="ticket-notification" style="display:none;">
                                <span class="notification" id="ticket-count"></span>
                                <input type="hidden" id='nombre_ticket' name="nombre_ticket">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <div id="0"></div>
                            <div id="1"></div>
                            <div id="2"></div>
                            <a href="{{ route('listTicketAdmin') }}"class="dropdown-item text-center"
                                onclick="localStorage.setItem('ticket_non_vu', 0);">Voir les tickets</a>
                        </div>
                    </div> --}}
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link" data-bs-toggle="dropdown">
                            <i class="fa fa-user"></i>
                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->nom_utilisateur }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">Parametre</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                {{ __('Deconnection') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Content End -->
            @yield('content')
        </div>
    </div>

</body>
<!-- Scripts -->

<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
{{-- <script src="{{ asset('js/jquery.min.js') }}"></script> --}}
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
{{-- <script src="{{ asset('js/darkmode.js') }}"></script> --}}
<script src="{{ asset('datatable/vendors/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
{{-- <script src="{{ asset('datatable/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script> --}}
{{-- <script src="{{ asset('datatable/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script> --}}
{{-- <script src="{{ asset('datatable/assets/js/init-scripts/data-table/datatables-init.js') }}"></script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('register-form');
        const inputs = form.querySelectorAll('input, select, textarea'); // tous les champs

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

            if (!isValid) e.preventDefault();
        });
    });
</script>
<script>
    function checkNewTickets() {

        $.ajax({
            url: "/check-new-tickets",
            method: "GET",
            success: function(response) {
                const count = response.nouveau_tickets;
                var tickets = response.tickets;
                // alert('executer'+count);

                if (count > 0) {
                    // alert(localStorage.getItem("ticket_non_vu").toString());
                    // alert('count :'+count);
                    if (parseInt(localStorage.getItem("ticket_non_vu")) == count) {
                        // alert('efa egal'+localStorage.getItem("ticket_non_vu"));



                    } else if (parseInt(localStorage.getItem("ticket_non_vu")) < count) {
                        var content = {};

                        content.message = 'Nouveau Ticket <div class=" m-4"><h5 class="fw-normal mb-0">' +
                            tickets[0].utilisateur.nom_utilisateur + '</h5><small class="text-dark">' +
                            tickets[0].objet + '</small></div>';
                        content.icon = 'fa fa-bell';
                        content.url = '/detailsTicket/' + tickets[0].id;
                        // content.target = '_blank';

                        $.notify(content, {
                            // type: 'success',
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                            // time: 5000,
                            timer: 8000,
                        });
                        // alert('hAFA'+localStorage.getItem("ticket_non_vu"));
                        // localStorage.setItem("ticket_non_vu", (count-1).toString());
                        localStorage.setItem("ticket_non_vu", count.toString());

                    } else {
                        localStorage.setItem("ticket_non_vu", count.toString());
                    }


                    $('#ticket-count').text(count);
                    $('#ticket-notification').fadeIn();
                    for (let i = 0; i < count; i++) {
                        document.getElementById(i).innerHTML = `<a href="/detailsTicket/${tickets[i].id}" class="dropdown-item">
                                <h6 class="fw-normal mb-0">${tickets[i].utilisateur.nom_utilisateur}</h6>
                                <small>${tickets[i].objet}</small>
                            </a><hr class="dropdown-divider">`;

                    }
                } else {
                    $('#ticket-notification').fadeOut();
                }
            },
            error: function(xhr) {
                console.error("Erreur AJAX :", xhr);
            }
        });
    }

    // Vérifie toutes les 30 secondes
    setInterval(checkNewTickets, 1000);
    // Appel initial immédiat au chargement
    checkNewTickets();
</script>
<script>
    // $(document).ready(function() {

    // });
    // Initialisation du tableau
    var table = $('#bootstrap-data-table-export').DataTable({
        dom: 'Bfrtip',
        buttons: [{
                extend: 'copy',
                text: 'Copier'
            },
            {
                extend: 'csv',
                text: 'CSV'
            },
            {
                extend: 'excel',
                text: 'Excel'
            },
            {
                extend: 'pdf',
                text: 'PDF'
            },
            {
                extend: 'print',
                text: 'Imprimer'
            }
        ],
        orderCellsTop: true,
        initComplete: function() {
            var api = this.api();
            var container = $('#filters');
            container.empty();

            // Générer les selects de filtre
            api.columns().every(function() {
                var column = this;
                var colTitle = $(column.header()).text();
                if (colTitle === 'Action') return; // Ignorer colonne Action
                if (colTitle === 'Id') return;
                // Créer le wrapper et le select
                var selectWrapper = $('<div class="col-md-2 mb-2">' +
                    '<label class="form-label fw-bold">' + colTitle + '</label>' +
                    '<select class="form-select form-select-sm">' +
                    '<option value="">Tous</option>' +
                    '</select>' +
                    '</div>');

                var select = selectWrapper.find('select');

                // Remplir le select avec les valeurs uniques (texte uniquement)
                column.data().unique().sort().each(function(d) {
                    if (d) {
                        // Extraire le texte visible même si d contient du HTML
                        var temp = $('<div>' + d + '</div>');
                        var text = temp.text().trim();
                        if (text) {
                            select.append('<option value="' + text + '">' + text +
                                '</option>');
                        }
                    }
                });

                // Ajouter le wrapper complet dans le container
                container.append(selectWrapper);

                // Événement onchange
                select.on('change', function() {
                    var val = $(this).val();

                    // Rechercher uniquement sur le texte visible (pas besoin de ^$)
                    column
                        .search(val ? val : '', true, false)
                        .draw();
                });
            });
        },
        language: {
            url: 'langue/fr.json'
        }
    });
</script>

</html>
