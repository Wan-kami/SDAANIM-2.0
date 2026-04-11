@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Tareas</h2>

    @if(session('success'))
    <p class="mensaje">{{ session('success') }}</p>
    @endif

    <a href="{{ route('admin.tasks.create') }}" class="fancy-btn" style="background-color: #4CAF50; color: white; margin-bottom: 20px;">+ Nueva Tarea</a>

    @if($tasks->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Asignado a</th>
                <th>Fecha Límite</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->Tar_id }}</td>
                <td>{{ $task->Tar_titulo }}</td>
                <td>{{ $task->user->name ?? 'N/A' }}</td>
                <td>{{ $task->Tar_fecha_limite }}</td>
                <td>
                    <form action="{{ route('admin.tasks.updateStatus', $task->Tar_id) }}" method="POST" style="display:inline;">
                        @csrf
                        <select name="Tar_estado" onchange="this.form.submit()" style="padding: 5px; border-radius: 4px;">
                            <option value="Pendiente" {{ $task->Tar_estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Observación" {{ $task->Tar_estado == 'Observación' ? 'selected' : '' }}>Observación</option>
                            <option value="En Proceso" {{ $task->Tar_estado == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                            <option value="Completado" {{ $task->Tar_estado == 'Completado' ? 'selected' : '' }}>Completado</option>
                        </select>
                    </form>
                </td>
                <td>
                    <a href="{{ route('admin.tasks') }}" style="padding: 5px 10px;">Ver</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-users">No hay tareas registradas.</p>
    @endif
</main>
@endsection
