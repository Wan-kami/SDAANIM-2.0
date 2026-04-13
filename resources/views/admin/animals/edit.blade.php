@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.animals') }}" class="fancy-btn"><span>← Volver</span></a>

    <section class="admin-form">
        <h2>Editar Animal: {{ $animal->Anim_nombre }}</h2>
        <form action="{{ route('admin.animals.update', $animal->Anim_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="Anim_nombre">Nombre del animal:</label>
            <input type="text" id="Anim_nombre" name="Anim_nombre" value="{{ $animal->Anim_nombre }}" required>

            <label for="Anim_raza">Raza:</label>
            <input type="text" id="Anim_raza" name="Anim_raza" value="{{ $animal->Anim_raza }}" required>

            <label for="Anim_edad">Edad:</label>
            <input type="text" id="Anim_edad" name="Anim_edad" value="{{ $animal->Anim_edad }}" required>

            <label for="Anim_estado">Estado:</label>
            <select id="Anim_estado" name="Anim_estado" required>
                <option value="Disponible" {{ $animal->Anim_estado == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="Adoptado" {{ $animal->Anim_estado == 'Adoptado' ? 'selected' : '' }}>Adoptado</option>
                <option value="En proceso" {{ $animal->Anim_estado == 'En proceso' ? 'selected' : '' }}>En proceso</option>
            </select>

            <label for="Anim_sexo">Sexo:</label>
            <select id="Anim_sexo" name="Anim_sexo">
                <option value="">Seleccionar</option>
                <option value="Macho" {{ $animal->Anim_sexo == 'Macho' ? 'selected' : '' }}>Macho</option>
                <option value="Hembra" {{ $animal->Anim_sexo == 'Hembra' ? 'selected' : '' }}>Hembra</option>
            </select>

            <label for="Anim_historia">Historia:</label>
            <textarea id="Anim_historia" name="Anim_historia" rows="4">{{ $animal->Anim_historia }}</textarea>

            <label for="Anim_foto">Imagen:</label>
            <input type="file" id="Anim_foto" name="Anim_foto" accept="image/*">

            @if($animal->Anim_foto)
            <p>Imagen actual:</p>
            <img src="{{ asset('img/' . $animal->Anim_foto) }}" width="150" style="border-radius: 8px;">
            @endif

            <button type="submit">Actualizar</button>
        </form>

        <form action="{{ route('admin.animals.destroy', $animal->Anim_id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este animal?')" style="margin-top: 20px;">
            @csrf
            @method('DELETE')
            <button type="submit" style="background-color: #dc3545;">Eliminar Animal</button>
        </form>
    </section>
</main>
@endsection
