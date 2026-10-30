@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-9 col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h3 fw-bold text-center mb-1">Crear cuenta</h1>
                    <p class="text-muted text-center mb-4">Regístrate para reservar tus citas en AppSalon</p>

                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" maxlength="60"
                                       class="form-control @error('nombre') is-invalid @enderror" required autofocus>
                                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido *</label>
                                <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" maxlength="60"
                                       class="form-control @error('apellido') is-invalid @enderror" required>
                                @error('apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="100"
                                   class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono <span class="text-muted">(opcional)</span></label>
                            <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" maxlength="10"
                                   class="form-control @error('telefono') is-invalid @enderror" placeholder="3001234567">
                            @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña *</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror" required>
                                <div class="form-text">Mínimo 6 caracteres.</div>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label">Repetir contraseña *</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-salon w-100 py-2">
                            <i class="bi bi-person-plus"></i> Crear cuenta
                        </button>
                    </form>

                    <p class="text-center mt-4 mb-0">
                        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-salon fw-semibold">Inicia sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection