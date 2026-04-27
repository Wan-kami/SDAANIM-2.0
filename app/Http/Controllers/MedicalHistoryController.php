<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Models\Animal;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalHistoryController extends Controller
{
    /**
     * Show history for a specific animal.
     */
    public function index($animal_id)
    {
        $animal = Animal::findOrFail($animal_id);
        $histories = MedicalHistory::where('Anim_id', $animal_id)
            ->with('vet')
            ->latest('Hist_fecha')
            ->get();
        return view('medical_histories.index', compact('animal', 'histories'));
    }

    /**
     * Store new medical record.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'Anim_id' => 'required|exists:animals,Anim_id',
            'His_descripcion' => 'required|string',
            'His_tratamiento' => 'nullable|string',
            'His_tipo' => 'required|in:Consulta,Vacuna,Revision,Urgencia',
        ]);

        $animal = Animal::find($data['Anim_id']);

        MedicalHistory::create([
            'Anim_id' => $data['Anim_id'],
            'Usu_documento' => Auth::user()->Usu_documento,
            'Hist_fecha' => now(),
            'Hist_diagnostico' => "[{$data['His_tipo']}] " . $data['His_descripcion'],
            'Hist_tratamiento' => $data['His_tratamiento'],
            'Hist_observaciones' => $request->get('Hist_observaciones', null),
        ]);

        // NOTIFY ADMIN IF URGENCY OR VACCINE
        if (in_array($data['His_tipo'], ['Vacuna', 'Urgencia', 'Revision'])) {
            $admin = User::where('role', 'Administrador')->first();
            if ($admin) {
                Notification::create([
                    'Usu_documento' => $admin->Usu_documento,
                    'Noti_mensaje' => "Nueva {$data['His_tipo']} registrada para {$animal->Anim_nombre} por Dr. " . Auth::user()->name,
                    'Noti_fecha' => now(),
                    'Noti_link' => route('admin.animals.index'),
                ]);
            }
        }

        return back()->with('success', 'Historial médico actualizado.');
    }
}
