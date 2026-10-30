@extends('layouts.app')

@section('title', 'Editar servicio')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('admin.servicios.index') }}" class="text-decoration-none text-salon small">
                <i class="bi bi-arrow-left"></i> Volver al listado
            </a>
            <div class="card border-0 shadow-sm mt-2">
                <div class="card-body p-4">
                    <h1 class="h4 fw-bold mb-4">Editar: {{ $servicio->nombre }}</h1>
                    <form method="POST" action="{{ route('admin.servicios.update', $servicio) }}" novalidate>
                        @csrf
                        @method('PUT') {{-- los formularios HTML solo envían GET/POST; Laravel simula PUT --}}
                        @include('admin.services._form', ['textoBoton' => 'Guardar cambios'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection