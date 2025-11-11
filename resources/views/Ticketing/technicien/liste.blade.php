<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CPA</title>

    <style>
        .marge-centree {
            margin-left: 3cm;
            margin-right: 3cm;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}" />

</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">

                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer" />
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">

                        <li class="sidebar-item">
                            <a href="./listeCabinet" class="sidebar-link">
                                <!-- <i class="bi bi-house-gear-fill"></i> -->
                                <span></span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="./listeMateriel" class="sidebar-link">
                                <!-- <i class="bi bi-grid-fill"></i> -->
                                <span></span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="./listeEmplacement" class="sidebar-link">
                                <!-- <i class="bi bi-grid-fill"></i> -->
                                <span></span>
                            </a>
                        </li>



                        <li class="sidebar-item">
                            <a href="./listeUtilisateur" class="sidebar-link">
                                <!-- <i class="bi bi-bag-plus-fill"></i> -->
                                <span></span>
                            </a>
                        </li>

                        <li class="sidebar-title">Menu :</li>
                        <li class="sidebar-item">
                            <a href="./indexAdmin" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Accueil</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="./listeCaracteristiqueSupplementaire" class="sidebar-link">
                                <i class="bi bi-basket-fill"></i>
                                <span>Matériel</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="./compte" class="sidebar-link">
                                <i class="bi bi-person-fill"></i>
                                <span>Compte</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="./listeMouvement" class="sidebar-link">
                                <!-- <i class="bi bi-basket-fill"></i> -->
                                <span></span>
                            </a>
                        </li>


                        <li class="sidebar-item">
                            <a href="./inventaire" class="sidebar-link">
                                <!-- <i class="bi bi-bag-plus-fill"></i> -->
                                <span></span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="./ticketing" class="sidebar-link">
                                <!-- <i class="bi bi-house-gear-fill"></i> -->
                                <span></span>
                            </a>
                        </li>


                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3 d-flex justify-content-between align-items-center">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
                <div class="ms-auto">
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-fill"></i>
                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->nom_utilisateur }}</span>
                        </a>
                        <div class="dropdown-menu">
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
            </header>
            <div class="card">
                <div class="card-header">
                    <h4>Liste de tous les tickets qui vous en été assigner</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <table id="bootstrap-data-table-export"
                                class="table table-hover table-responsive table-bordered">
                                <thead>
                                    <tr>
                                        <th>Numero</th>
                                        <th>Demandeur</th>
                                        <th>Objet</th>
                                        <th>Priorite</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                </thead>
                                <tbody>
                                    {{-- {{ dd($tickets); }} --}}
                                    @foreach ($tickets as $ticket)
                                        <tr>

                                            <td>{{ $ticket->id }}</td>
                                            <td>{{ $ticket->utilisateur->nom_utilisateur }}</td>
                                            <td>{{ $ticket->objet }}</td>
                                        <td class="text-center" style="color: {{ $ticket->priorite->color() }}">
                                            <span class="badge" style="background-color: {{ $ticket->priorite->color() }};">
                                            </span>
                                            {{ $ticket->priorite->label() }}
                                        </td>
                                            <td class="text-center">
                                                @if ($ticket->statut=='ATTRIBUE')
                                                                                                <span class="badge bg-warning"
                                                   >
                                                    À traiter
                                                </span>
                                                    @else
                                                                                                    <span class="badge"
                                                    style="background-color: {{ $ticket->statut->color() }}">
                                                    {{ $ticket->statut->label() }}
                                                </span>
                                                @endif

                                            </td>
                                            <td>
                                                {{ $ticket->created_at }}
                                            </td>
                                            <td>
                                                 <a href="{{ route('TicketTechnicien.details', $ticket->id) }}"
                                                    class="btn btn-outline-info btn-xs">Details</i></a>
                                                <a href="{{ route('resolution', $ticket->id) }}">Résoudre</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
            <script src="{{ asset('extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

            <script src="{{ asset('assets/compiled/js/app.js') }}"></script>

            <!-- Need: Apexcharts -->
            <script src="{{ asset('extensions/apexcharts/apexcharts.min.js') }}"></script>

            <?php
            
            function toMonth($numero)
            {
                $mois = [
                    '01' => 'Jan',
                    '02' => 'Fev',
                    '03' => 'Mar',
                    '04' => 'Avr',
                    '05' => 'Mai',
                    '06' => 'Jui',
                    '07' => 'Juil',
                    '08' => 'Aout',
                    '09' => 'Sept',
                    '10' => 'Oct',
                    '11' => 'Nov',
                    '12' => 'Dec',
                ];
            
                return $mois[$numero] ?? 'numero invalide';
            }
            
            ?>

            <script>
                var optionsProfileVisit = {
                    annotations: {
                        position: "back",
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    chart: {
                        type: "bar",
                        height: 300,
                    },
                    fill: {
                        opacity: 1,
                    },
                    plotOptions: {},

                }
            </script>


            <script></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
