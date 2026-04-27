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
     * Display a listing for admin.
     */
    public function index()
    {
        $animals = Animal::where('Anim_estado', '!=', 'Adoptado')->latest('Anim_id')->get();

        if (auth()->user()->role === 'Veterinario') {
            return view('home.vet_animals', compact('animals'));
        }

        return view('admin.animals.index', compact('animals'));
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.animals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'Anim_nombre' => 'required|string|max:100',
            'Anim_raza' => 'required|string|max:100',
            'Anim_edad' => 'required|string|max:100',
            'Anim_sexo' => 'required|string|max:10',
            'Anim_historia' => 'nullable|string',
            'Anim_estado' => 'required|string|max:20',
            'Anim_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('Anim_foto')) {
            $imageName = time() . '.' . $request->Anim_foto->extension();
            $request->Anim_foto->move(public_path('img'), $imageName);
            $data['Anim_foto'] = $imageName;
        }

        Animal::create($data);

        return redirect()->route('admin.animals.index')->with('success', 'Animal creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $animal = Animal::findOrFail($id);
        return view('admin.animals.edit', compact('animal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);

        $data = $request->validate([
            'Anim_nombre' => 'required|string|max:100',
            'Anim_raza' => 'required|string|max:100',
            'Anim_edad' => 'required|string|max:100',
            'Anim_sexo' => 'required|string|max:10',
            'Anim_historia' => 'nullable|string',
            'Anim_estado' => 'required|string|max:20',
            'Anim_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('Anim_foto')) {
            $imageName = time() . '.' . $request->Anim_foto->extension();
            $request->Anim_foto->move(public_path('img'), $imageName);
            $data['Anim_foto'] = $imageName;
        }

        $animal->update($data);

        return redirect()->route('admin.animals.index')->with('success', 'Animal actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);
        $animal->delete();
        return redirect()->route('admin.animals.index')->with('success', 'Animal eliminado.');
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
        $años = isset($matches[0]) ? (int) $matches[0] : 0;

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

        $aboutController = new AboutController();
        $about = $aboutController->getAboutDataPublic();

        return view('home.adopter', compact('animals', 'about'));
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
