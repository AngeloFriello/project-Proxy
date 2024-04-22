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
        <div class="loading-overlay">
            <div class="loading-spinner"></div>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-5">
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <a href="{{ route('admin.payment.index') }}?perPage={{session('perPage')}}" class=""><img class="logo" src="{{asset('immagine.png')}}" alt=""></a>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item d-flex">
                        
                        <a class=" btn btn-secondary mx-3" href="{{ url('/') }}">{{ __('Home') }}</a>
                        <a href="{{ route('admin.payment.index') }}?perPage={{session('perPage')}}" class="btn btn-secondary">Payments</a>
                    </li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('profile/settings') }}">{{ __('Settings') }}</a>
                                <a class="dropdown-item" href="{{ url('admin/payment') }}">{{ __('Payments') }}</a>     
                                <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profile') }}</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
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
        </nav>

        <main role="main" class="">
            @yield('content')
        </main>
            
    </div>
</body>

</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aggiungi una classe al documento quando lo script è in caricamento
    document.documentElement.classList.add('loading');
});

// Rimuovi la classe quando lo script è completamente caricato
document.querySelector('script[src="http://192.168.1.8:5173/resources/js/app.js"]').addEventListener('load', function() {
    document.documentElement.classList.remove('loading');
});
document.addEventListener('DOMContentLoaded', function() {
            // Aggiungi la classe "loaded" quando lo script è completamente caricato
            document.documentElement.classList.add('loaded');
        });

        // Rimuovi la classe "loaded" quando lo script è completamente caricato
        document.querySelector('script[src="http://192.168.1.8:5173/resources/js/app.js"]').addEventListener('load', function() {
            document.documentElement.classList.remove('loaded');
        });
</script>