<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display a listing of animals for the public.
     */
    public function publicIndex(Request $request)
    {
        $etapaFiltro = $request->get('etapa', 'todos');

        $query = Animal::where('Anim_estado', 'Disponible');

        if ($etapaFiltro !== 'todos') {
            // We need to filter by age string logic like original
            // This is better done by fetching and filtering in collection or a complex query
            $animals = $query->get()->filter(function ($animal) use ($etapaFiltro) {
                return $this->obtenerEtapa($animal->Anim_edad) === $etapaFiltro;
            });
        } else {
            $animals = $query->latest('Anim_id')->get();
        }

        return view('animals.public_index', compact('animals', 'etapaFiltro'));
    }

    /**
     * Display a listing for veterinarians.
     */
    public function index()
    {
        $animals = Animal::latest('Anim_id')->get();
        
        if (auth()->user()->role === 'Veterinario') {
            return view('home.vet_animals', compact('animals'));
        }

        return redirect('/');
    }

    /**
     * Show detailed view.
     */
    public function show($id)
    {
        $animal = Animal::findOrFail($id);
        return view('animals.show', compact('animal'));
    }

    /**
     * Helper to get stage from age text.
     */
    private function obtenerEtapa($edadTexto)
    {
        $edadTexto = strtolower($edadTexto);

        if (str_contains($edadTexto, 'mes')) {
            return 'cachorro';
        }

        preg_match('/\d+/', $edadTexto, $matches);
        $años = isset($matches[0]) ? (int)$matches[0] : 0;

        if ($años <= 2) {
            return 'cachorro';
        } elseif ($años >= 3 && $años <= 7) {
            return 'joven';
        } else {
            return 'adulto';
        }
    }

    public function adopterDashboard()
    {
        $animals = Animal::where('Anim_estado', 'Disponible')
                        ->latest('Anim_id')
                        ->take(6)
                        ->get();

        return view('home.adopter', compact('animals'));
    }

    /**
     * Get medical history for an animal (API endpoint)
     */
    public function getMedicalHistory($id)
    {
        $animal = Animal::findOrFail($id);
        $histories = $animal->medicalHistories()->latest('Hist_fecha')->get();

        $data = [
            'histories' => $histories->map(function ($history) {
                return [
                    'fecha' => \Carbon\Carbon::parse($history->Hist_fecha)->format('d/m/Y'),
                    'diagnostico' => $history->Hist_diagnostico,
                    'tratamiento' => $history->Hist_tratamiento,
                    'observaciones' => $history->Hist_observaciones,
                    'vet' => $history->vet ? $history->vet->name : 'No especificado'
                ];
            })
        ];

        return response()->json($data);
    }
}
