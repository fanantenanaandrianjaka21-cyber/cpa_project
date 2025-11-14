<?php
// dd(Auth::user()->equipe);
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Expert CPA', 'Expert CPA') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
        <nav class="navbar navbar-expand-md navbar-light">

            <div class="container">
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
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

        <main class="py-4 content-center">
            @yield('content')
        </main>
    </div>

</body>

<script src="{{ asset('cpa/js/custom.js') }}"></script>

</html>