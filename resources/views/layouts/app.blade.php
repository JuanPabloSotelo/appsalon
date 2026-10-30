<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inicio') | {{ config('app.name') }}</title>

    {{-- Bootstrap 5 e íconos desde CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Estilos propios --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

{{-- ===== Barra de navegación ===== --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-salon shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('inicio') }}">
            <i class="bi bi-scissors"></i> AppSalon
        </a>

        {{-- Botón hamburguesa para celulares --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                aria-controls="menu" aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            {{-- Enlaces de la izquierda --}}
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}" href="{{ route('inicio') }}">Inicio</a>
                </li>

                {{-- Route::has() muestra el enlace solo cuando la ruta ya existe (se crean en los pasos 5 y 7) --}}
                @if (Route::has('servicios.index'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('servicios.*') ? 'active' : '' }}" href="{{ route('servicios.index') }}">Servicios</a>
                    </li>
                @endif

                @auth
                    @if (auth()->user()->esAdmin() && Route::has('admin.servicios.index'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.servicios.index') }}">
                                <i class="bi bi-gear"></i> Administrar servicios
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            {{-- Enlaces de la derecha: invitado vs. usuario autenticado --}}
            <ul class="navbar-nav align-items-lg-center gap-2">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Iniciar sesión</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-light btn-sm text-salon fw-semibold" href="{{ route('register') }}">Crear cuenta</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->nombre }}
                            @if (auth()->user()->esAdmin())
                                <span class="badge bg-warning text-dark ms-1">Admin</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text small text-muted">{{ auth()->user()->email }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            @if (Route::has('logout'))
                                <li>
                                    {{-- Logout por POST con token CSRF (más seguro que un enlace GET) --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- ===== Contenido de cada página ===== --}}
<main class="flex-grow-1">
    <div class="container mt-3">
        @include('partials.alerts')
    </div>

    @yield('content')
</main>

{{-- ===== Pie de página ===== --}}
<footer class="bg-dark text-white-50 py-3 mt-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between small">
        <span>&copy; {{ date('Y') }} AppSalon — Sistema de gestión de citas</span>
        <span>Proyecto académico · Universidad Santiago de Cali</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>