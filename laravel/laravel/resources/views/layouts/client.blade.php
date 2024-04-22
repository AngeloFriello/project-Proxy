<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Usando Vite -->
    {{-- @vite(['resources/js/app.js']) --}}

    <script type="module" src="http://192.168.1.8:5173/resources/js/app.js" onload=""></script>

    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255); /* Sfondo bianco semi-trasparente */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Assicura che l'overlay sia in cima a tutti gli altri elementi */
        }
        /* Stile per la rotella di caricamento */
        .loading-spinner {
            border: 4px solid #f3f3f3; /* Grigio chiaro */
            border-top: 4px solid #3498db; /* Blu */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite; /* Animazione di rotazione */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Nascondi l'overlay quando lo script è completamente caricato */
        .loaded .loading-overlay {
            display: none;
        }
    </style>
</head>
<body>
    <div id="app">
        @yield('content')
            
    </div>
</body>