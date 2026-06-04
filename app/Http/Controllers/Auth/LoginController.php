<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'Usu_documento' => ['required', 'integer'],
            'password' => ['required'],
        ], [
            'Usu_documento.required' => 'Debes ingresar tu número de documento.',
            'Usu_documento.integer' => 'El número de documento solo puede contener dígitos.',
            'password.required' => 'Debes ingresar tu contraseña.',
        ]);

        if (Auth::attempt(['Usu_documento' => $credentials['Usu_documento'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            session()->flash('welcome', '¡Bienvenido ' . $user->name . '! Has ingresado como ' . $user->role);

            // Redirect based on role
            return match ($user->role) {
                'Voluntario' => redirect()->route('volunteer.dashboard'),
                'Veterinario' => redirect()->route('vet.dashboard'),
                'Adoptante' => redirect()->route('adopter.dashboard'),
                'Administrador' => redirect()->route('admin.dashboard'),
                default => redirect()->route('dashboard'),
            };
        }

        return back()->withErrors([
            'Usu_documento' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('Usu_documento');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
