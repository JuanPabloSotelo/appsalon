<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Controlador de autenticación: registro, confirmación, login y logout.
 */
class AuthController extends Controller
{
    /** Muestra el formulario de registro. */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Registra un nuevo cliente.
     * La validación ya ocurrió en RegisterRequest antes de entrar aquí.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        $usuario = User::create([
            'nombre'   => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'email'    => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'password' => Hash::make($datos['password']),   // bcrypt
            'token'    => Str::random(15),                   // token de confirmación
        ]);
        // 'admin' y 'confirmado' quedan en 0 por defecto (definido en la migración)

        $this->enviarCorreoConfirmacion($usuario);

        return redirect()->route('login')
            ->with('success', 'Cuenta creada. Te enviamos un correo para confirmarla antes de iniciar sesión.');
    }

    /** Confirma la cuenta cuando el usuario abre el enlace del correo. */
    public function confirm(string $token): RedirectResponse
    {
        $usuario = User::where('token', $token)->first();

        if (! $usuario) {
            return redirect()->route('login')
                ->with('error', 'El enlace de confirmación no es válido o ya fue utilizado.');
        }

        $usuario->confirmado = true;
        $usuario->token = null;   // el token es de un solo uso
        $usuario->save();

        return redirect()->route('login')
            ->with('success', '¡Cuenta confirmada! Ya puedes iniciar sesión.');
    }

    /** Muestra el formulario de inicio de sesión. */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /** Valida credenciales e inicia la sesión. */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credenciales = $request->validated();

        // 1. ¿El correo y la contraseña son correctos? (compara contra el hash bcrypt)
        if (! Auth::validate($credenciales)) {
            return back()
                ->withErrors(['email' => 'El correo o la contraseña son incorrectos.'])
                ->onlyInput('email');
        }

        // 2. ¿La cuenta está confirmada?
        $usuario = User::where('email', $credenciales['email'])->first();

        if (! $usuario->confirmado) {
            return back()
                ->with('error', 'Tu cuenta aún no está confirmada. Revisa tu correo.')
                ->onlyInput('email');
        }

        // 3. Iniciar sesión y regenerar el ID de sesión (evita fijación de sesión)
        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->intended(route('inicio'))
            ->with('success', "¡Bienvenido, {$usuario->nombre}!");
    }

    /** Cierra la sesión por completo. */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();       // destruye los datos de la sesión
        $request->session()->regenerateToken();  // nuevo token CSRF

        return redirect()->route('inicio')->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Envía el correo con el enlace de confirmación.
     * Con MAIL_MAILER=log el correo se guarda en storage/logs/laravel.log.
     */
    private function enviarCorreoConfirmacion(User $usuario): void
    {
        $enlace = route('confirmar', $usuario->token);

        try {
            Mail::raw(
                "Hola {$usuario->nombre},\n\nGracias por registrarte en AppSalon.\n"
                . "Confirma tu cuenta abriendo este enlace:\n{$enlace}\n\n"
                . "Si no creaste esta cuenta, ignora este mensaje.",
                fn ($mensaje) => $mensaje->to($usuario->email)->subject('Confirma tu cuenta - AppSalon')
            );
        } catch (\Throwable $e) {
            // Manejo de errores: si falla el correo, se registra y el registro no se cae
            Log::error('No se pudo enviar el correo de confirmación: ' . $e->getMessage());
        }
    }
}