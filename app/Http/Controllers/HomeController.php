<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Página de inicio: muestra tres servicios activos como destacados.
     */
    public function index(): View
    {
        $destacados = Service::activos()->orderBy('nombre')->take(3)->get();

        return view('home', compact('destacados'));
    }
}