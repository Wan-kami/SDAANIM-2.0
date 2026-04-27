<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function sendResetCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_document' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput()
                ->with('showForgotModal', true);
        }

        $input = trim($request->email_or_document);

        $user = User::where('email', $input)
            ->orWhere('Usu_documento', $input)
            ->first();

        if (!$user) {
            return back()->withErrors(['email_or_document' => 'No se encontró un usuario con ese correo o cédula.'])
                ->withInput()
                ->with('showForgotModal', true);
        }

        $codigo = rand(100000, 999999);

        session([
            'password_reset_user_id' => $user->id,
            'password_reset_user_email' => $user->email,
            'password_reset_user_name' => $user->name,
            'password_reset_code' => $codigo,
        ]);
        session()->save();

        Mail::raw("Tu código de recuperación de contraseña es: $codigo", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Código de recuperación de contraseña - Esperanza Animal BQ');
        });

        return back()->with('success', 'Se envió un código al correo registrado. Revisa tu bandeja de entrada.')
            ->with('showVerifyModal', true);
    }

    public function verifyResetCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput()
                ->with('showVerifyModal', true);
        }

        $codigoIngresado = trim($request->codigo);
        $codigoGuardado = session('password_reset_code');

        if (!$codigoGuardado) {
            return back()->with('error', 'La sesión del código expiró. Por favor, vuelve a solicitarlo.')
                ->with('showForgotModal', true);
        }

        if ($codigoIngresado !== (string) $codigoGuardado) {
            return back()->withErrors(['codigo' => 'Código incorrecto.'])
                ->with('showVerifyModal', true);
        }

        \Log::debug('PasswordResetController verify request', [
            'session_user_id' => session('password_reset_user_id'),
            'session_email' => session('password_reset_user_email'),
            'request_codigo' => $codigoIngresado,
            'expected_codigo' => $codigoGuardado,
        ]);

        session([
            'password_reset_verified' => true,
            'password_reset_user_id' => session('password_reset_user_id'),
            'password_reset_user_email' => session('password_reset_user_email'),
            'password_reset_user_name' => session('password_reset_user_name'),
        ]);
        session()->save();

        return back()->with('success', 'Código verificado. Ahora ingresa tu nueva contraseña.')
            ->with('showResetModal', true);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=(?:.*\d){5})(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&\-_#]).{8,}$/',
            ],
        ], [
            'password.regex' => 'La contraseña debe tener mínimo 8 caracteres, al menos 5 números, 1 mayúscula, 1 minúscula y 1 carácter especial (@$!%*?&-_#).',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput()
                ->with('showResetModal', true);
        }

        \Log::debug('PasswordResetController reset request', [
            'session_user_id' => session('password_reset_user_id'),
            'session_email' => session('password_reset_user_email'),
            'request_user_id' => $request->input('password_reset_user_id'),
            'request_email' => $request->input('password_reset_user_email'),
            'has_verified' => session('password_reset_verified'),
        ]);

        $userId = $request->input('password_reset_user_id') ?: session('password_reset_user_id');
        $userEmail = $request->input('password_reset_user_email') ?: session('password_reset_user_email');
        $verified = session('password_reset_verified') || $request->input('password_reset_verified');

        if (!$verified || (!$userId && !$userEmail)) {
            return back()->with('error', 'No hay validación de código activa. Inicia el proceso nuevamente.')
                ->with('showForgotModal', true);
        }

        $userQuery = User::query();
        if ($userId && $userEmail) {
            $userQuery->where(function ($query) use ($userId, $userEmail) {
                $query->where('Usu_documento', $userId)
                      ->orWhere('email', $userEmail);
            });
        } elseif ($userId) {
            $userQuery->where('Usu_documento', $userId);
        } elseif ($userEmail) {
            $userQuery->where('email', $userEmail);
        }

        $user = $userQuery->first();

        if (!$user) {
            return back()->with('error', 'Usuario no encontrado.')->with('showForgotModal', true);
        }

        $user->password = $request->password;
        $user->save();

        session()->forget(['password_reset_user_id', 'password_reset_user_email', 'password_reset_user_name', 'password_reset_code', 'password_reset_verified']);

        return redirect()->route('login')->with('success', 'Contraseña actualizada con éxito. Ya puedes iniciar sesión.');
    }
}
