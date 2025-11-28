<?php
// dd(Auth::user()->equipe);
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Expert CPA', 'Expert CPA') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('cpa/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('cpa/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!---->
    <link rel="stylesheet" href="{{ asset('cpa/css/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cpa/css/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cpa/css/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cpa/css/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('datatable/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">

    <script src="{{ asset('cpa/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('soutenance/js/jquery.min.js') }}"></script>
    <script src="{{ asset('soutenance/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('soutenance/js/aos.js') }}"></script>
    <script src="{{ asset('soutenance/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('soutenance/js/smoothscroll.js') }}"></script>
    <script src="{{ asset('soutenance/js/custom.js') }}"></script>

    <style>
        body {
            /* background-color: azure; */
            background-image: url("{{ asset('asset/Parcpc7.jpeg') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100%;
            /* Assure que le body occupe toute la hauteur de la vue */
            min-height: 87vh; 
            display: flex;
            flex-direction: column;
        }

        #app {
            flex-grow: 1; 
            display: flex;
            flex-direction: column;
        }
        
        /* CSS CORRIGÉ : Centrage vertical et horizontal */
        .content-center {
            display: flex;
            align-items: center; /* Centrage vertical */
            justify-content: center; /* Centrage horizontal */
            flex-grow: 1; /* Permet à main de prendre tout l'espace sous la navbar */
            /* Retirez le padding vertical si vous utilisez full-height-center pour un centrage parfait */
            padding-top: 0 !important; 
            padding-bottom: 0 !important; 
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light  shadow-sm">

            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- <img src="{{ asset('asset/logocpa.png') }}" style="height:50px;width: auto;" alt="Logo cpa"> --}}
                    <h2 class="expertcpa"><i class="fa fa-user-edit me-2"></i>GPTic CPA</h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nom_utilisateur }}
                                </a>

                                <div class="dropdown-menu dropdown-cust" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Deconnexion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>

<!-- Plugin JavaScript -->
{{-- <script src="{{ asset('cpa/js/custom.js') }}"></script> --}}
<script src="{{ asset('datatable/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('datatable/assets/js/init-scripts/data-table/datatables-init.js') }}"></script>

</html>
