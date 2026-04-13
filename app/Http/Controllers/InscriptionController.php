<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
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

}
