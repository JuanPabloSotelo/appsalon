@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h3 fw-bold text-center mb-1">Iniciar sesión</h1>
                    <p class="text-muted text-center mb-4">Ingresa para reservar y gestionar tus citas</p>

                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf {{-- token contra ataques CSRF --}}

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="tucorreo@ejemplo.com" required autofocus>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-salon w-100 py-2">
                            <i class="bi bi-box-arrow-in-right"></i> Ingresar
                        </button>
                    </form>

                    <p class="text-center mt-4 mb-0">
                        ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-salon fw-semibold">Regístrate aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection