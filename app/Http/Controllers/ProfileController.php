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
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->Usu_documento . ',Usu_documento',
            'password' => 'nullable|string|min:8|confirmed',
            'Usu_telefono' => 'nullable|string|max:15',
            'Usu_direccion' => 'nullable|string|max:255',
            'Usu_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
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
            'password' => 'required|string|min:8|confirmed',
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

}
