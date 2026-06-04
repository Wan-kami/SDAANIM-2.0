<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\BienvenidaMail;

class RegisterController extends Controller
{
    // MOSTRAR FORMULARIO
    public function showRegistrationForm()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {

        $data = $request->validate([
            'Usu_documento' => ['required', 'regex:/^[0-9]+$/', 'unique:users,Usu_documento'],
            'name' => ['required', 'string', 'max:150', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'Usu_telefono' => ['required', 'string', 'max:20', 'regex:/^[\d\s()+-]+$/'],
            'Usu_direccion' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s#\-\.,]+$/'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=(?:.*\d){5})(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&\-_#]).{8,}$/',
            ],
        ], [
            'password.regex' => 'La contraseña debe tener mínimo 8 caracteres, al menos 5 números, 1 mayúscula, 1 minúscula y 1 carácter especial (@$!%*?&-_#).',
            'Usu_documento.regex' => 'El documento no puede tener puntos ni letras, solo números.',
            'name.regex' => 'El nombre solo puede contener letras y espacios, sin números ni caracteres especiales.',
            'email.email' => 'Debes ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'Usu_telefono.regex' => 'El teléfono solo puede contener números, espacios, paréntesis, guiones y el símbolo +.',
            'Usu_direccion.regex' => 'La dirección solo puede contener letras, números, espacios y estos símbolos: # - , .',
        ]);

        // 🔢 Generar código
        $codigo = rand(100000, 999999);

        // 💾 Guardar temporal
        session([
            'registro_temp' => $data,
            'codigo_verificacion' => $codigo
        ]);

        // 📩 Enviar correo de verificación con diseño
        Mail::send('emails.verification_code', [
            'nombre' => $data['name'],
            'codigo' => $codigo,
            'documento' => $data['Usu_documento'],
        ], function ($message) use ($data) {
            $message->to($data['email'])
                ->subject('Código de verificación - Esperanza Animal BQ');
        });

        return redirect()->route('register')->with('mostrar_modal', true);
    }

    // ✅ VERIFICAR CÓDIGO Y CREAR USUARIO
    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required'
        ]);

        $codigoIngresado = $request->codigo;
        $codigoGuardado = session('codigo_verificacion');
        $data = session('registro_temp');

        if (!$data) {
            return redirect()->route('register')
                ->with('error', 'Sesión expirada')
                ->with('mostrar_modal', true);
        }

        if ($codigoIngresado != $codigoGuardado) {
            return redirect()->route('register')
                ->with('error', 'Código incorrecto ❌')
                ->with('mostrar_modal', true);
        }

        // ✅ Crear usuario
        $user = User::create([
            'Usu_documento' => $data['Usu_documento'],
            'name' => $data['name'],
            'email' => $data['email'],
            'Usu_telefono' => $data['Usu_telefono'],
            'Usu_direccion' => $data['Usu_direccion'],
            'password' => Hash::make($data['password']),
            'role' => 'Adoptante',
            'status' => 'Activo',
        ]);

        // 📩 Bienvenida
        Mail::to($user->email)
            ->send(new BienvenidaMail($user->name));

        // 🧹 Limpiar sesión
        session()->forget(['registro_temp', 'codigo_verificacion']);

        return redirect()->route('login')
            ->with('success', 'Cuenta verificada y creada ✅');
    }
}
