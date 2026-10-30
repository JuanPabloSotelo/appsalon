@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    {{-- Encabezado principal --}}
    <section class="hero py-5 mb-5">
        <div class="container py-lg-4 text-center">
            <h1 class="display-5 fw-bold">Tu estilo, en el horario que tú elijas</h1>
            <p class="lead mb-4">Reserva tus citas en AppSalon de forma rápida y segura.</p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                @if (Route::has('servicios.index'))
                    <a href="{{ route('servicios.index') }}" class="btn btn-light btn-lg text-salon fw-semibold">Ver servicios</a>
                @endif
                @guest
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Crear cuenta</a>
                    @endif
                @endguest
            </div>
        </div>
    </section>

    {{-- Servicios destacados (vienen de la base de datos) --}}
    <section class="container mb-5">
        <h2 class="h3 fw-bold text-center mb-4">Servicios destacados</h2>

        <div class="row g-4">
            @forelse ($destacados as $servicio)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm card-servicio">
                        <div class="card-body">
                            <h3 class="h5 card-title">{{ $servicio->nombre }}</h3>
                            <p class="card-text text-muted">{{ $servicio->descripcion }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="precio">${{ number_format($servicio->precio, 0, ',', '.') }}</span>
                                <span class="badge bg-secondary"><i class="bi bi-clock"></i> {{ $servicio->duracion }} min</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Aún no hay servicios registrados.</p>
            @endforelse
        </div>
    </section>

    {{-- Cómo funciona --}}
    <section class="container mb-5">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <i class="bi bi-person-plus display-6 text-salon"></i>
                <h3 class="h5 mt-2">1. Crea tu cuenta</h3>
                <p class="text-muted">Regístrate con tu correo en menos de un minuto.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-list-check display-6 text-salon"></i>
                <h3 class="h5 mt-2">2. Elige tus servicios</h3>
                <p class="text-muted">Selecciona uno o varios servicios del catálogo.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-calendar-check display-6 text-salon"></i>
                <h3 class="h5 mt-2">3. Reserva tu cita</h3>
                <p class="text-muted">Escoge la fecha y la hora que más te convenga.</p>
            </div>
        </div>
    </section>
@endsection