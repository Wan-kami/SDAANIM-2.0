<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\User;
use App\Mail\InscriptionApprovedMail;
use App\Mail\InscriptionRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InscriptionController extends Controller
{
    /**
     * Admin list of pending inscriptions.
     */
    public function adminIndex()
    {
        $inscriptions = Inscription::where('ins_estado', 'Pendiente')->latest()->get();
        return view('admin.inscriptions.index', compact('inscriptions'));
    }

    /**
     * Show volunteer sign-up form.
     */
    public function createVolunteer()
    {
        return view('public.volunteer');
    }

    /**
     * Show veterinarian sign-up form.
     */
    public function createVeterinarian()
    {
        return view('public.veterinarian');
    }

    /**
     * Store a new inscription.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ins_documento' => 'required|string|max:20',
            'ins_nombre' => 'required|string|max:100',
            'ins_email' => 'required|email|max:100',
            'ins_direccion' => 'nullable|string|max:150',
            'ins_telefono' => 'nullable|string|max:20',
            'ins_tipo_rol' => 'required|in:voluntario,veterinario',
            'ins_especialidad' => 'nullable|string|max:100',
            'ins_experiencia_anos' => 'nullable|integer|min:0',
            'ins_certificado' => 'nullable|string|max:150',
            'ins_tipo_ayuda' => 'required|string|max:100',
            'ins_comentario' => 'nullable|string',
        ]);

        Inscription::create($data);

        return back()->with('success', 'Gracias por tu interés. Tu inscripción se ha enviado correctamente y pronto estaremos en contacto.');
    }

    /**
     * Approve inscription and create user.
     */
    public function approve(Request $request, $id)
    {
        $ins = Inscription::findOrFail($id);
        
        // 1. Generate temporary password
        $passwordTemporal = Str::random(12);
        
        // 2. Create User
        $user = User::create([
            'Usu_documento' => $ins->ins_documento,
            'name' => $ins->ins_nombre,
            'email' => $ins->ins_email,
            'Usu_telefono' => $ins->ins_telefono,
            'Usu_direccion' => $ins->ins_direccion,
            'role' => ucfirst($ins->ins_tipo_rol), // 'Voluntario' or 'Veterinario'
            'password' => $passwordTemporal,
            'status' => 'Activo',
        ]);

        // 3. Mark Inscription as Approved
        $ins->update(['ins_estado' => 'Aprobada']);

        // 4. Send approval email with credentials
        Mail::to($ins->ins_email)->send(new InscriptionApprovedMail(
            $ins->ins_nombre,
            $ins->ins_email,
            $ins->ins_documento,
            $passwordTemporal,
            $ins->ins_tipo_rol
        ));

        return back()->with('success', "Solicitud aprobada. El usuario {$ins->ins_nombre} ha sido creado y se le envió un correo con sus credenciales.");
    }

    /**
     * Reject inscription.
     */
    public function reject($id)
    {
        $ins = Inscription::findOrFail($id);
        $ins->update(['ins_estado' => 'Rechazada']);
        
        // Send rejection email
        Mail::to($ins->ins_email)->send(new InscriptionRejectedMail(
            $ins->ins_nombre,
            $ins->ins_email,
            $ins->ins_tipo_rol
        ));

        return back()->with('success', "Solicitud de {$ins->ins_nombre} rechazada. Se envió un correo notificando el rechazo.");
    }
}
