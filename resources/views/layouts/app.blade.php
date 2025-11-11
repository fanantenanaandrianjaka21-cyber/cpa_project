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
   
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('asset/logocpa.png') }}" style="height:60px;width: auto;" alt="Logo cpa">
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
                        <!-- Authentication Links -->
                        @guest
                            <!-- @if (Route::has('login'))
    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Se connecter') }}</a>
                                    </li>
    @endif

                                @if (Route::has('register'))
    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('S\'inscrire') }}</a>
                                    </li>
    @endif-->
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle smooth-scroll" href="#" id="navbarDropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Materiels</a>
                                <div class="dropdown-menu dropdown-cust" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/inscription">Etat Actuel des materiels</a>
                                    <a class="dropdown-item" href="/inscription">Materiels en stock</a>
                                    <a href="#" class="dropdown-item" data-toggle="modal"
                                        data-target="#search-modal">Ajout</a>

                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle smooth-scroll" href="#" id="navbarDropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mouvement Stocks</a>
                                <div class="dropdown-menu dropdown-cust" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/inscription">Entré</a>
                                    <a href="#" class="dropdown-item" data-toggle="modal"
                                        data-target="#search-modal">Affectation</a>
                                    <a class="dropdown-item" href="/transfert">Retour</a>
                                    <a class="dropdown-item" href="/transfert">Matériel hors d’usage</a>

                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle smooth-scroll" href="#" id="navbarDropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Inventaire</a>
                                <div class="dropdown-menu dropdown-cust" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/inscription">Nouveau inventaire</a>
                                    <a class="dropdown-item" href="/transfert">Historique des inventaires</a>

                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle smooth-scroll" href="#"
                                    id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">Maintenance</a>
                                <div class="dropdown-menu dropdown-cust" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/inscription">Demande des utilisateurs</a>
                                    <a class="dropdown-item" href="/inscription">Intervention en cours</a>
                                    <a class="dropdown-item" href="/transfert">Historique des maintenances</a>

                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle smooth-scroll" href="#"
                                    id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">Utilisateurs</a>
                                <div class="dropdown-menu dropdown-cust" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">Liste des utilisateurs</a>
                                    <a class="dropdown-item" href="/inscription">Nouveau utilisateur</a>

                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nom_utilisateur }}
                                </a>

                                <div class="dropdown-menu dropdown-cust" aria-labelledby="navbarDropdownMenuLink">
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
                            </li>

                        @endguest
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
<script src="{{ asset('cpa/js/custom.js') }}"></script>

</html>
