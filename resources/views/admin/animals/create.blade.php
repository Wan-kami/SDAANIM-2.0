@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.animals') }}" class="fancy-btn"><span>← Volver</span></a>

    <section class="admin-form">
        <h2>Agregar nuevo animal en adopción 🐾</h2>
        <form action="{{ route('admin.animals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="Anim_nombre">Nombre del animal:</label>
            <input type="text" id="Anim_nombre" name="Anim_nombre" placeholder="Ej. Luna" required>

            <label for="Anim_raza">Raza:</label>
            <input type="text" id="Anim_raza" name="Anim_raza" placeholder="Ej. pitbull" required>

            <label for="Anim_edad">Edad:</label>
            <input type="text" id="Anim_edad" name="Anim_edad" placeholder="Ej. 3 años" required>

            <label for="Anim_sexo">Sexo:</label>
            <select id="Anim_sexo" name="Anim_sexo">
                <option value="">Seleccionar</option>
                <option value="Macho">Macho</option>
                <option value="Hembra">Hembra</option>
            </select>

            <label for="Anim_estado">Estado:</label>
            <select id="Anim_estado" name="Anim_estado" required>
                <option value="">Seleccionar</option>
                <option value="Disponible">Disponible</option>
                <option value="Adoptado">Adoptado</option>
                <option value="En proceso">En proceso</option>
            </select>

            <label for="Anim_historia">Historia del animal:</label>
            <textarea id="Anim_historia" name="Anim_historia" placeholder="Describe la historia del animal..." rows="4"></textarea>

            <label for="Anim_foto">Subir imagen:</label>
            <input type="file" id="Anim_foto" name="Anim_foto" accept="image/*" required>

            <button type="submit">Agregar</button>
        </form>
    </section>
</main>
@endsection
