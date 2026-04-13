@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.tasks') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Nueva Tarea</h2>

    <div class="admin-form" style="max-width: 600px;">
        <form action="{{ route('admin.tasks.store') }}" method="POST">
            @csrf

            <label for="Usu_documento">Asignar a:</label>
            <select name="Usu_documento" id="Usu_documento" required>
                <option value="">Seleccionar usuario</option>
                <optgroup label="Voluntarios">
                    @foreach($users->where('role', 'Voluntario') as $user)
                    <option value="{{ $user->Usu_documento }}">{{ $user->name }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="Veterinarios">
                    @foreach($users->where('role', 'Veterinario') as $user)
                    <option value="{{ $user->Usu_documento }}">{{ $user->name }}</option>
                    @endforeach
                </optgroup>
            </select>

            <label for="Tar_titulo">Título:</label>
            <input type="text" name="Tar_titulo" id="Tar_titulo" required placeholder="Ej. Seguimiento de adopción">

            <label for="Tar_descripcion">Descripción:</label>
            <textarea name="Tar_descripcion" id="Tar_descripcion" rows="4" required placeholder="Descripción detallada de la tarea..."></textarea>

            <label for="Tar_base">Base/Lugar:</label>
            <input type="text" name="Tar_base" id="Tar_base" value="Centro Principal">

            <label for="Tar_fecha_asignacion">Fecha de Asignación:</label>
            <input type="date" name="Tar_fecha_asignacion" id="Tar_fecha_asignacion" value="{{ date('Y-m-d') }}">

            <label for="Tar_fecha_limite">Fecha Límite:</label>
            <input type="date" name="Tar_fecha_limite" id="Tar_fecha_limite" required>

            <label for="Tar_hora">Hora:</label>
            <input type="time" name="Tar_hora" id="Tar_hora">

            <label for="Soli_id">Solicitud de Adopción (opcional):</label>
            <select name="Soli_id" id="Soli_id">
                <option value="">Ninguna</option>
                @foreach($adoptions as $adoption)
                <option value="{{ $adoption->Soli_id }}">#{{ $adoption->Soli_id }} - {{ $adoption->animal->Anim_nombre ?? 'N/A' }}</option>
                @endforeach
            </select>

            <button type="submit">Crear Tarea</button>
        </form>
    </div>
</main>
@endsection
