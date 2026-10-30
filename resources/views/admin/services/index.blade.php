@extends('layouts.app')

@section('title', 'Administrar servicios')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <h1 class="h3 fw-bold mb-0"><i class="bi bi-gear text-salon"></i> Administrar servicios</h1>
        <a href="{{ route('admin.servicios.create') }}" class="btn btn-salon">
            <i class="bi bi-plus-lg"></i> Nuevo servicio
        </a>
    </div>

    {{-- Búsqueda --}}
    <form method="GET" action="{{ route('admin.servicios.index') }}" class="row g-2 mb-3">
        <div class="col-sm-8 col-md-6">
            <input type="text" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar por nombre...">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-secondary"><i class="bi bi-search"></i> Buscar</button>
            @if ($buscar !== '')
                <a href="{{ route('admin.servicios.index') }}" class="btn btn-link text-muted">Limpiar</a>
            @endif
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th class="text-end">Precio</th>
                        <th class="text-center">Duración</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($servicios as $servicio)
                        <tr>
                            <td>
                                <strong>{{ $servicio->nombre }}</strong>
                                <div class="small text-muted text-truncate" style="max-width: 280px;">{{ $servicio->descripcion }}</div>
                            </td>
                            <td class="text-end">${{ number_format($servicio->precio, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $servicio->duracion }} min</td>
                            <td class="text-center">
                                @if ($servicio->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.servicios.edit', $servicio) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.servicios.destroy', $servicio) }}" class="d-inline"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar el servicio {{ $servicio->nombre }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No se encontraron servicios.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $servicios->links() }}
    </div>
</div>
@endsection