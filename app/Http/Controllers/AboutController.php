<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    private $disk = 'local';
    private $file = 'about.json';

    public function show()
    {
        $about = $this->getAboutData();
        return view('public.about', compact('about'));
    }

    public function edit()
    {
        $about = $this->getAboutData();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'historia' => 'required',
            'mision' => 'required',
            'vision' => 'required',
        ]);

        $data = [
            'historia' => $request->historia,
            'mision' => $request->mision,
            'vision' => $request->vision,
        ];

        Storage::disk($this->disk)->put($this->file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return back()->with('success', 'La información de Quiénes Somos ha sido actualizada.');
    }

    public function adopterEdit()
    {
        $about = $this->getAboutData();
        return view('adopter.history.edit', compact('about'));
    }

    public function adopterUpdate(Request $request)
    {
        $request->validate([
            'historia' => 'required',
            'mision' => 'required',
            'vision' => 'required',
        ]);

        $data = [
            'historia' => $request->historia,
            'mision' => $request->mision,
            'vision' => $request->vision,
        ];

        Storage::disk($this->disk)->put($this->file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return back()->with('success', 'La historia ha sido actualizada correctamente.');
    }

    private function getAboutData()
    {
        if (Storage::disk($this->disk)->exists($this->file)) {
            return json_decode(Storage::disk($this->disk)->get($this->file), true);
        }

        return [
            'historia' => 'Conoce nuestra misión, visión y valores como fundación dedicada al bienestar animal 🐾',
            'mision' => 'Promover la adopción responsable de animales rescatados, ofreciendo un sistema digital que optimice la gestión del refugio, facilite el acceso a la información de los animales en espera y agilice el proceso de adopción. Buscamos mejorar la calidad de vida de los peluditos y fomentar hogares responsables que les brinden amor y cuidado.',
            'vision' => 'Para el año 2040 seremos una plataforma líder en adopción responsable de animales en Colombia, reconocida por su innovación tecnológica y su impacto social, expandiendo nuestra solución a múltiples refugios y convirtiéndonos en un referente en la protección animal y el bienestar comunitario.',
        ];
    }

    public function getAboutDataPublic()
    {
        return $this->getAboutData();
    }
}
