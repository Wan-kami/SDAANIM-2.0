@extends('layouts.app')

@section('content')
<main>
    <!-- Professional Header -->
    <div class="animals-header-wrapper">
        <a href="{{ route('admin.dashboard') }}" class="btn-back-animals" title="Volver al Panel">
            <span class="back-icon-animals">←</span>
        </a>
        <div class="animals-header-content">
            <h1>🐾 Gestión de Mascotas en Adopción</h1>
            <p class="animals-subtitle">Administra, edita o agrega nuevos amigos peludos</p>
        </div>
    </div>

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

<style>
    /* Professional Header Styles */
    .animals-header-wrapper {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 2rem;
    }

    .animals-header-content {
        flex: 1;
    }

    .animals-header-content h1 {
        font-size: 2rem;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .animals-subtitle {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
        text-align: left;
    }

    /* Back Button */
    .btn-back-animals {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #f0f0f0;
        color: #333;
        text-decoration: none;
        border-radius: 50%;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-right: 1rem;
        font-size: 1.2rem;
        border: 2px solid #e0e0e0;
        flex-shrink: 0;
    }

    .btn-back-animals:hover {
        background: #4CAF50;
        color: white;
        border-color: #4CAF50;
        transform: scale(1.1);
    }

    .back-icon-animals {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

@endsection
