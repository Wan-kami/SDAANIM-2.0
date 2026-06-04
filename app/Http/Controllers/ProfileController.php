<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show profile page (view mode with action buttons).
     */
    public function edit()
    {
        $user = Auth::user();
        $role = strtolower($user->role);
        
        $view = "profiles.edit_{$role}";
        
        if (!view()->exists($view)) {
            $view = 'profiles.edit';
        }

        return view($view, compact('user'));
    }

    /**
     * Update profile data.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => ['nullable','string','email','max:255','unique:users,email,' . $user->Usu_documento . ',Usu_documento'],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=(?:.*\d){5})(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&\-_#]).{8,}$/',
            ],
            'Usu_telefono' => ['nullable','string','max:15','regex:/^[\d\s()+-]+$/'],
            'Usu_direccion' => ['nullable','string','max:255','regex:/^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s#\-\.,]+$/'],
            'Usu_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ], [
            'name.regex' => 'El nombre solo puede contener letras y espacios, sin números ni caracteres especiales.',
            'email.email' => 'Debes ingresar un correo electrónico válido.',
            'email.unique' => 'Ese correo ya está en uso.',
            'password.regex' => 'La contraseña debe tener mínimo 8 caracteres, al menos 5 números, 1 mayúscula, 1 minúscula y 1 carácter especial (@$!%*?&-_#).',
            'Usu_telefono.regex' => 'El teléfono solo puede contener números, espacios, paréntesis, guiones y el símbolo +.',
            'Usu_direccion.regex' => 'La dirección solo puede contener letras, números, espacios y estos símbolos: # - , .',
        ]);

        // Update only provided fields
        if (isset($data['name']) && !empty($data['name'])) {
            $user->name = $data['name'];
        }
        if (isset($data['email']) && !empty($data['email'])) {
            $user->email = $data['email'];
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }
        if (isset($data['Usu_telefono'])) {
            $user->Usu_telefono = $data['Usu_telefono'];
        }
        if (isset($data['Usu_direccion'])) {
            $user->Usu_direccion = $data['Usu_direccion'];
        }

        // Profile photo upload
        if ($request->hasFile('Usu_foto')) {
            $imageName = 'profile_' . $user->Usu_documento . '.' . $request->Usu_foto->extension();
            $request->Usu_foto->move(public_path('img/profiles'), $imageName);
            $user->Usu_foto = $imageName;
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Change password only.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
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

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    /**
     * Deactivate own account.
     */
    public function deactivate(Request $request)
    {
        $user = Auth::user();
        $user->status = 'Desactivado';
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Tu cuenta ha sido desactivada.');
    }

    /**
     * Admin Index for users.
     */
    public function adminIndex()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Admin toggle user status.
     */
    public function adminToggleStatus($documento)
    {
        $user = User::findOrFail($documento);
        
        if ($user->Usu_documento == Auth::user()->Usu_documento) {
            return back()->with('error', 'No puedes cambiar tu propio estado de esta manera.');
        }

        $user->status = $user->status === 'Activo' ? 'Desactivado' : 'Activo';
        $user->save();

        return back()->with('success', 'Estado del usuario actualizado correctamente.');
    }
}
