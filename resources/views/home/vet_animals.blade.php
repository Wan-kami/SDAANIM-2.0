@extends('layouts.app')

@section('panel-title', 'Animales')

@section('content')
<div class="premium-dashboard-container">
    @include('partials.vet_sidebar')

    <main class="dashboard-main-panel">
        <div class="tasks-page-container">
            <div class="tasks-page-header">
                <h1>Animales Registrados</h1>
                <p>Selecciona un animal para ver su historial médico o agregar registros.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-top: 10px;">
                @foreach($animals as $animal)
                    <div style="background: white; border-radius: 15px; padding: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); text-align: center; border-bottom: 4px solid #7FFFD4;">
                        <img src="{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
                        <h3>{{ $animal->Anim_nombre }}</h3>
                        <p>{{ $animal->Anim_raza }} - {{ $animal->Anim_edad }}</p>
                        <a href="{{ route('vet.history', $animal->Anim_id) }}" style="display: inline-block; margin-top: 10px; background: #20B2AA; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold;">Ver Historial Médico</a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
@endsection
