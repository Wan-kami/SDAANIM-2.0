<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{

    public function show()
    {
        $about = \App\Models\AboutPage::first();
        if (!$about) {
            $about = \App\Models\AboutPage::create([
                'mision' => 'Proteger y cuidar animales en situación de vulnerabilidad.',
                'vision' => 'Ser un refugio modelo en la protección animal.',
                'valores' => json_encode(['Compasión', 'Responsabilidad', 'Dedicación']),
            ]);
        }
        return view('public.about', compact('about'));
    }

    public function edit()
    {
        $about = \App\Models\AboutPage::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'mision' => 'required',
            'vision' => 'required',
            'valores' => 'nullable',
        ]);

        $about = \App\Models\AboutPage::first();
        $data = [
            'mision' => $request->mision,
            'vision' => $request->vision,
            'valores' => $request->valores,
        ];

        if ($about) {
            $about->update($data);
        } else {
            \App\Models\AboutPage::create($data);
        }

        return back()->with('success', 'La información de Quiénes Somos ha sido actualizada.');
    }

    public function adopterEdit()
    {
        $about = \App\Models\AboutPage::first();
        return view('adopter.history.edit', compact('about'));
    }

    public function adopterUpdate(Request $request)
    {
        $request->validate([
            'mision' => 'required',
            'vision' => 'required',
        ]);

        $about = \App\Models\AboutPage::first();
        $data = [
            'mision' => $request->mision,
            'vision' => $request->vision,
        ];

        if ($about) {
            $about->update($data);
        }

        return back()->with('success', 'La historia ha sido actualizada correctamente.');
    }

    public function getAboutDataPublic()
    {
        return \App\Models\AboutPage::first() ?: (object)[
            'mision' => 'Promover la adopción responsable.',
            'vision' => 'Ser un referente.',
            'valores' => json_encode(['Amor', 'Respeto'])
        ];
    }
}
