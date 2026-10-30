<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Página de inicio (pública)
Route::get('/', [HomeController::class, 'index'])->name('inicio');

// Rutas solo para visitantes NO autenticados
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1');   // máx. 5 intentos por minuto (contra fuerza bruta)

    Route::get('/confirmar/{token}', [AuthController::class, 'confirm'])->name('confirmar');
});

// Cerrar sesión (solo usuarios autenticados, por POST)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');