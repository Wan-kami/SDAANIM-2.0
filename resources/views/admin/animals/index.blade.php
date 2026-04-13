@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>
    <h2>Gestión de Mascotas en Adopción</h2>
    <p style="text-align:center;">Administra, edita o agrega nuevos amigos peludos 🐶🐾</p>

    <div class="adopta-grid">
        @forelse($animals as $animal)
        <div class="adopta-card">
            @if($animal->Anim_foto)
            <img src="{{ asset('img/' . $animal->Anim_foto) }}" alt="{{ $animal->Anim_nombre }}">
            @else
            <img src="{{ asset('img/default.png') }}" alt="Sin imagen">
            @endif
            <h3>{{ $animal->Anim_nombre }}</h3>
            <p>Raza: {{ $animal->Anim_raza }}</p>
            <p>Edad: {{ $animal->Anim_edad }}</p>
            <p>Estado: 
                @if($animal->Anim_estado == 'Disponible')
                <span style="color: #4CAF50; font-weight: bold;">{{ $animal->Anim_estado }}</span>
                @elseif($animal->Anim_estado == 'Adoptado')
                <span style="color: #2196F3; font-weight: bold;">{{ $animal->Anim_estado }}</span>
                @else
                <span style="color: #FFC107; font-weight: bold;">{{ $animal->Anim_estado }}</span>
                @endif
            </p>
            <div style="display: flex; gap: 5px; justify-content: center; flex-wrap: wrap;">
                <button onclick="window.location.href='{{ route('admin.animals.edit', $animal->Anim_id) }}'">Editar</button>
                <form action="{{ route('admin.animals.destroy', $animal->Anim_id) }}" method="POST" onsubmit="return confirm('¿Eliminar este animal?')" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background-color: #dc3545;">Eliminar</button>
                </form>
            </div>
        </div>
        @empty
        <p style="text-align:center; grid-column: 1/-1;">No hay animales registrados aún 🐾</p>
        @endforelse

        <div class="adopta-card add-card" onclick="window.location.href='{{ route('admin.animals.create') }}'">
            <img src="{{ asset('img/agregar.png') }}" alt="Agregar nuevo">
            <h3>Agregar nueva mascota</h3>
        </div>
    </div>
</main>
@endsection
