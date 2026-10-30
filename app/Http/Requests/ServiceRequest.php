<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validación al crear o editar un servicio.
 */
class ServiceRequest extends FormRequest
{
    /** El acceso ya lo controla el middleware 'admin'. */
    public function authorize(): bool
    {
        return true;
    }

    /** El checkbox "activo" llega como "0" o "1"; se convierte a booleano. */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => trim((string) $this->nombre),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        return [
            // Nombre único; al editar se ignora el propio servicio
            'nombre'      => ['required', 'string', 'max:60',
                              Rule::unique('servicios', 'nombre')->ignore($this->route('servicio'))],
            'precio'      => ['required', 'numeric', 'min:0', 'max:99999999'],
            'duracion'    => ['required', 'integer', 'min:10', 'max:480'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'activo'      => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'max'      => 'El campo :attribute no puede superar :max.',
            'min'      => 'El campo :attribute debe ser como mínimo :min.',
            'numeric'  => 'El campo :attribute debe ser un número.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            'unique'   => 'Ya existe un servicio con ese nombre.',
        ];
    }

    public function attributes(): array
    {
        return [
            'duracion'    => 'duración (minutos)',
            'descripcion' => 'descripción',
        ];
    }
}