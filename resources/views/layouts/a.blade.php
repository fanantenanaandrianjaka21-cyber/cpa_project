<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Expert CPA', 'Expert CPA') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('cpa/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('cpa/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!-- Template Stylesheet -->
    <link href="{{ asset('charttest/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('datatable/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <script src="{{ asset('cpa/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('soutenance/js/jquery.min.js') }}"></script>
    <script src="{{ asset('soutenance/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('soutenance/js/aos.js') }}"></script>
    <script src="{{ asset('soutenance/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('soutenance/js/smoothscroll.js') }}"></script>
    <script src="{{ asset('soutenance/js/custom.js') }}"></script>
    <script src="stylenet/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="stylenet/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="stylenet/dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="stylenet/plugins/chart.js/Chart.min.js"></script>
    <script src="stylenet/dist/js/demo.js"></script>
    <!--<script src="stylenet/dist/js/pages/dashboard3.js"></script>-->



</head>

<body>
    <div id="app">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar ">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('asset/logocpa.png') }}" style="height:50px;width: auto;" alt="Logo cpa">
                </a>

                <div class="navbar-nav w-100">
                    <!-- active -->
                    <a href="#" class="nav-item nav-link active" id="displayNotif"><i
                            class="fa fa-tachometer"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link " data-bs-toggle="dropdown"><i
                                class="fa fa-building"></i>Emplacements</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="/listeEmplacement" class="dropdown-item">Liste Emplacement</a>
                            <a href="/formEmplacement" class="dropdown-item">Nouveau Emplacement</a>

                        </div>
                    </div>
                    <a href="{{ route('gestionMateriels') }}" class="nav-item nav-link"><i class="fa fa-exchange"></i>Stocks</a>
                    <a href="{{ route('tousLesMateriels') }}" class="nav-item nav-link"><i
                            class="fa fa-laptop me-2"></i>Materiels</a>
                    <a href="{{ route('affectation.liste') }}" class="nav-item nav-link"><i
                            class="fa fa-history"></i>Affectation</a>
                    <a href="{{ route('inventaire.faire') }}" class="nav-item nav-link"><i
                            class="fa fa-table me-2"></i>Inventaire</a>
                    <a href="chart.html" class="nav-item nav-link"><i class="fa fa-cogs"></i> Maintenance</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link" data-bs-toggle="dropdown"><i class="fa fa-user"
                                style="font-size: 20px;"></i>Utilisateur</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{ route('user.liste') }}" class="dropdown-item">Liste des Utilisateurs</a>
                            <a href="/inscription" class="dropdown-item">Nouveau Utilisateur</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->
        <main class="py-4">
            <div class="position-relative d-flex p-0">
                <!-- Spinner Start -->
                {{-- <div id="spinner"
                    class="show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div> --}}
                <!-- Spinner End -->
                <!-- Content Start -->
                <div class="content">
                    <!-- Navbar Start -->
                    <nav class="navbar navbar-expand bg-info sticky-top px-4 py-0">
                        <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                            <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                        </a>
                        <a href="#" class="sidebar-toggler flex-shrink-0">
                            <i class="fa fa-bars"></i>
                        </a>

                        <div class="navbar-nav align-items-center ms-auto">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                                    <i class="fa fa-bell"></i>
                                    <span class="d-none d-lg-inline-flex">Notification</span>
                                    <span class="notification">5</span>
                                </a>
                                <div
                                    class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                    <a href="#" class="dropdown-item">
                                        <h6 class="fw-normal mb-0">Nouveau materiel ajouté</h6>
                                        <small>15 minutes ago</small>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="#" class="dropdown-item">
                                        <h6 class="fw-normal mb-0">Nouveau utilisateur ajouté</h6>
                                        <small>15 minutes ago</small>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="#" class="dropdown-item">
                                        <h6 class="fw-normal mb-0">Notification n</h6>
                                        <small>15 minutes ago</small>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="#" class="dropdown-item text-center">Voir tous les
                                        notifications</a>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                                    <i class="fa fa-user"></i>
                                    <span class="d-none d-lg-inline-flex">{{ Auth::user()->nom_utilisateur }}</span>
                                </a>
                                <div
                                    class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                    <a href="#" class="dropdown-item">Parametre</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                        {{ __('Deconnection') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
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
        </main>
    </div>
</body>
<!-- Template Javascript -->
{{-- <script src="{{ asset('charttest/js/main.js') }}"></script> --}}
<!-- Plugin JavaScript -->
{{-- <script src="{{ asset('cpa/js/custom.js') }}"></script> --}}
<script src="{{ asset('datatable/vendors/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('datatable/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('datatable/assets/js/init-scripts/data-table/datatables-init.js') }}"></script>
<script>
    $('#displayNotif').on('click', function() {
        var content = {};

        content.message = 'Turning standard Bootstrap alerts into "notify" like notifications';
        content.title = 'Bootstrap notify';
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
    });
</script>

</html>

