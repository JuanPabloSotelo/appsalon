<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación del formulario de registro (lado servidor).
 */
class RegisterRequest extends FormRequest
{
    /** Cualquier visitante puede registrarse. */
    public function authorize(): bool
    {
        return true;
    }

    /** Limpia los datos antes de validarlos. */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre'   => trim((string) $this->nombre),
            'apellido' => trim((string) $this->apellido),
            'email'    => strtolower(trim((string) $this->email)),
            'telefono' => trim((string) $this->telefono) ?: null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre'   => ['required', 'string', 'max:60', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'string', 'max:60', 'regex:/^[\pL\s]+$/u'],
            'email'    => ['required', 'string', 'email', 'max:100', 'unique:usuarios,email'],
            'telefono' => ['nullable', 'digits:10'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    /** Mensajes de error en español. */
    public function messages(): array
    {
        return [
            'required'  => 'El campo :attribute es obligatorio.',
            'max'       => 'El campo :attribute no puede tener más de :max caracteres.',
            'regex'     => 'El campo :attribute solo puede contener letras y espacios.',
            'email'     => 'Ingresa un correo electrónico válido.',
            'unique'    => 'Este correo ya está registrado.',
            'digits'    => 'El teléfono debe tener exactamente :digits números.',
            'min'       => 'La contraseña debe tener al menos :min caracteres.',
            'confirmed' => 'Las contraseñas no coinciden.',
        ];
    }

    /** Nombres de los campos para los mensajes. */
    public function attributes(): array
    {
        return [
            'email'    => 'correo electrónico',
            'telefono' => 'teléfono',
            'password' => 'contraseña',
        ];
    }
}