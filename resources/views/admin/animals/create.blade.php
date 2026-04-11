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

            <label for="Anim_foto">Subir imagen:</label>
            <input type="file" id="Anim_foto" name="Anim_foto" accept="image/*" required>

            <button type="submit">Agregar</button>
        </form>
    </section>
</main>
@endsection
