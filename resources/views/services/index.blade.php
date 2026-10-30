@extends('layouts.app')

@section('title', 'Servicios')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Nuestros servicios</h1>
        <p class="text-muted">Elige entre {{ $servicios->count() }} servicios disponibles</p>
    </div>

    @guest
        <div class="alert alert-light border text-center">
            <i class="bi bi-info-circle text-salon"></i>
            ¿Quieres reservar? <a href="{{ route('register') }}" class="text-salon fw-semibold">Crea tu cuenta</a>
            o <a href="{{ route('login') }}" class="text-salon fw-semibold">inicia sesión</a>.
        </div>
    @endguest

    <div class="row g-4">
        @forelse ($servicios as $servicio)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm card-servicio">
                    <div class="card-body d-flex flex-column">
                        <h2 class="h5 card-title">{{ $servicio->nombre }}</h2>
                        <p class="card-text text-muted flex-grow-1">{{ $servicio->descripcion ?: 'Sin descripción.' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="precio">${{ number_format($servicio->precio, 0, ',', '.') }}</span>
                            <span class="badge bg-secondary"><i class="bi bi-clock"></i> {{ $servicio->duracion }} min</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Por ahora no hay servicios disponibles.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection