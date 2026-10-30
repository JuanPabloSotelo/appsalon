<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Servicios del salón: catálogo público y CRUD para administradores.
 */
class ServiceController extends Controller
{
    /* ========== PÚBLICO ========== */

    /** Catálogo de servicios activos (visible para cualquier visitante). */
    public function catalogo(): View
    {
        $servicios = Service::activos()->orderBy('nombre')->get();

        return view('services.index', compact('servicios'));
    }

    /* ========== ADMINISTRADOR ========== */

    /** Listado con búsqueda por nombre y paginación. */
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->query('buscar'));

        $servicios = Service::query()
            ->when($buscar !== '', fn ($q) => $q->where('nombre', 'like', "%{$buscar}%"))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('admin.services.index', compact('servicios', 'buscar'));
    }

    /** Formulario de creación. */
    public function create(): View
    {
        $servicio = new Service(['duracion' => 60, 'activo' => true]);

        return view('admin.services.create', compact('servicio'));
    }

    /** Guarda un servicio nuevo (ya validado por ServiceRequest). */
    public function store(ServiceRequest $request): RedirectResponse
    {
        $servicio = Service::create($request->validated());

        return redirect()->route('admin.servicios.index')
            ->with('success', "Servicio \"{$servicio->nombre}\" creado correctamente.");
    }

    /** Formulario de edición. */
    public function edit(Service $servicio): View
    {
        return view('admin.services.edit', compact('servicio'));
    }

    /** Actualiza un servicio existente. */
    public function update(ServiceRequest $request, Service $servicio): RedirectResponse
    {
        $servicio->update($request->validated());

        return redirect()->route('admin.servicios.index')
            ->with('success', "Servicio \"{$servicio->nombre}\" actualizado correctamente.");
    }

    /**
     * Elimina un servicio.
     * Si ya está en alguna cita, no se borra (se perdería el historial): se desactiva.
     */
    public function destroy(Service $servicio): RedirectResponse
    {
        try {
            if ($servicio->citas()->exists()) {
                $servicio->update(['activo' => false]);

                return redirect()->route('admin.servicios.index')
                    ->with('warning', "\"{$servicio->nombre}\" tiene citas asociadas, por eso no se eliminó: se desactivó y ya no aparece en el catálogo.");
            }

            $nombre = $servicio->nombre;
            $servicio->delete();

            return redirect()->route('admin.servicios.index')
                ->with('success', "Servicio \"{$nombre}\" eliminado correctamente.");
        } catch (QueryException $e) {
            Log::error('Error al eliminar servicio: ' . $e->getMessage());

            return redirect()->route('admin.servicios.index')
                ->with('error', 'Ocurrió un error al eliminar el servicio. Intenta de nuevo.');
        }
    }
}