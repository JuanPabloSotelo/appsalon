<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Página de inicio (pública)
Route::get('/', [HomeController::class, 'index'])->name('inicio');

// PRUEBA TEMPORAL de mensajes flash — borrar al terminar el paso 4
Route::get('/prueba-mensaje', function () {
    return redirect()->route('inicio')->with('success', '¡Los mensajes de estado funcionan!');
});