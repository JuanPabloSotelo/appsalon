<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// ===== Rutas públicas =====
Route::get('/', [HomeController::class, 'index'])->name('inicio');
Route::get('/servicios', [ServiceController::class, 'catalogo'])->name('servicios.index');

// ===== Solo visitantes NO autenticados =====
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1');   // máx. 5 intentos por minuto

    Route::get('/confirmar/{token}', [AuthController::class, 'confirm'])->name('confirmar');
});

// ===== Usuarios autenticados =====
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ===== Solo administradores: auth (sesión) + admin (rol) =====
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Genera: index, create, store, edit, update, destroy
    Route::resource('servicios', ServiceController::class)
        ->except(['show'])
        ->parameters(['servicios' => 'servicio']);
});