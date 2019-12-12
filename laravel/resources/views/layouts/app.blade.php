<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AnnotateMe') }}</title>

    <!-- Scripts -->
    <!-- cannot read property 'fn' of undefined bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap4-toggle.js') }}"></script>
    <script src="{{ asset('js/cookie.js') }}" defer></script>


    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap4-toggle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @if(session()->has('expert'))
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('home') }}">List Projects</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('account.list') }}">List Experts</a>
                    </li>
                    @if(strpos(session('expert')['type'],'admin') !== false)
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ route('project.create') }}">Create Project</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ route('account.create') }}">Create Account</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <span class="caret">{{ ucfirst(strtolower(session()->get('expert')['firstname'])) }} {{ strtoupper(session()->get('expert')['name']) }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('account.read', ['id' => session('expert')['id']]) }}">
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('auth.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<main class="py-4">
    @yield('content')
</main>
@include('layouts.RGPD')
</body>
</html>
