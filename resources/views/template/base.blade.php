<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Brújula de Papel')</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
    <header class="app-header">
        <div class="container nav-container">
            
            <a class="brand" href="{{ route('main.index') }}">
                <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S12 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S12 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                </svg>
                Brújula de Papel
            </a>

            <ul class="nav-menu">
                <li><a class="nav-link" href="{{ route('main.index') }}">Ofertas</a></li>
                
                @auth
                <li><a class="nav-link" href="{{ route('home') }}">Mis Reservas</a></li>
                @endauth

                @if(Auth::user() != null && Auth::user()->isAdmin())
                <li class="dropdown">
                    <span class="nav-link">Admin &#9662;</span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('vacacion.index') }}">Gestionar Vacaciones</a></li>
                        <li><a class="dropdown-item" href="{{ route('vacacion.create') }}">Nueva Oferta</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('user.index') }}">Gestionar Usuarios</a></li>
                    </ul>
                </li>
                @endif
            </ul>

            <form class="search-form" method="get" action="{{ route('main.index') }}">
                @foreach(request()->except(['page','q']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                
                <div class="search-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input name="q" class="search-input" type="search" value="{{ $q ?? '' }}" placeholder="Buscar destino...">
                </div>
            </form>

            <ul class="auth-nav">
                @guest
                <li><a class="btn-login" href="{{ route('login') }}">Login</a></li>
                <li><a class="btn-register" href="{{ route('register') }}">Registro</a></li>
                @else
                <li class="dropdown">
                    <span class="nav-link">{{ Auth::user()->name }} &#9662;</span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('home') }}">Mi Perfil</a></li>
                        <li>
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item btn-logout text-danger">Cerrar Sesión</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>

        </div>
    </header>

    <div class="container main-content">
        @error('general')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        @if(session('general'))
        <div class="alert alert-success">{{ session('general') }}</div>
        @endif

        @yield('modal')
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>