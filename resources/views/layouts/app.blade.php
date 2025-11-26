<?php
// dd(Auth::user()->equipe);
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('GPTic CPA', 'GPTic CPA') }}</title>

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
    <main class="py-4 content-center">
            @yield('content')
        </main>
    </div>

</body>

<script src="{{ asset('cpa/js/custom.js') }}"></script>

</html>