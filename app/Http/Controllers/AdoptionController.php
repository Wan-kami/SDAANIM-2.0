<?php

namespace App\Http\Controllers;

use App\Mail\AdoptionRequestStatusMail;
use App\Models\Animal;
use App\Models\AdoptionRequest;
use App\Models\Notification;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdoptionController extends Controller
{
    /**
     * Show form to request adoption.
     */
    public function create($animal_id)
    {
        $animal = Animal::findOrFail($animal_id);
        return view('adoptions.create', compact('animal'));
    }

    /**
     * Store request.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'animal_id' => 'required|exists:animals,Anim_id',
            'motivo' => 'required|string',
            'otras_mascotas' => 'nullable|string',
            'tipo_vivienda' => 'required|string',
            'tiempo_disponible' => 'required|string',
            'comentarios' => 'nullable|string',
        ]);

        $animal = Animal::findOrFail($data['animal_id']);

        $solicitud = AdoptionRequest::create([
            'Usu_documento' => Auth::user()->Usu_documento,
            'Anim_id' => $data['animal_id'],
            'Soli_motivo' => $data['motivo'],
            'Soli_otras_mascotas' => $data['otras_mascotas'],
            'Soli_tipo_vivienda' => $data['tipo_vivienda'],
            'Soli_tiempo_disponible' => $data['tiempo_disponible'],
            'Soli_comentarios' => $data['comentarios'],
            'Soli_estado' => 'Pendiente',
        ]);

        Mail::to(Auth::user()->email)->send(new AdoptionRequestStatusMail(
            subjectLine: 'Solicitud de adopción enviada correctamente',
            name: Auth::user()->name,
            animalName: $animal->Anim_nombre,
            status: 'Pendiente',
            emailMessage: "Hemos recibido tu solicitud de adopción para {$animal->Anim_nombre}. Un voluntario la revisará pronto y te avisaremos cuando programemos la visita a tu hogar.",
            visitDate: null,
            volunteerName: null,
            actionUrl: route('adopter.requests')
        ));

        return redirect()->route('adopter.requests')
            ->with('success', 'Solicitud enviada correctamente.');
    }

    /**
     * List user's requests.
     */
    public function userRequests()
    {
        $requests = AdoptionRequest::where('Usu_documento', Auth::user()->Usu_documento)
            ->with('animal')
            ->latest()
            ->get();

        return view('adoptions.user_index', compact('requests'));
    }

    private function sendAdopterStatusEmail(AdoptionRequest $solicitud, string $subject, string $emailMessage, ?string $visitDate = null, ?string $volunteerName = null)
    {
        Mail::to($solicitud->user->email)->send(new AdoptionRequestStatusMail(
            subjectLine: $subject,
            name: $solicitud->user->name,
            animalName: $solicitud->animal->Anim_nombre,
            status: $solicitud->Soli_estado,
            emailMessage: $emailMessage,
            visitDate: $visitDate,
            volunteerName: $volunteerName,
            actionUrl: route('adopter.requests')
        ));
    }
}
