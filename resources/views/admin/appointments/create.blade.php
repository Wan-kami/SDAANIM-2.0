@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>
    <h2>Asignar Cita Veterinaria</h2>

    <div class="form-container">
        <form action="{{ route('admin.appointments.store') }}" method="POST">
            @csrf

            <label for="Anim_id">Animal:</label>
            <select name="Anim_id" id="Anim_id" required>
                <option value="">Seleccionar</option>
                @foreach($animals as $animal)
                <option value="{{ $animal->Anim_id }}">{{ $animal->Anim_nombre }}</option>
                @endforeach
            </select>

            <label for="Usu_documento">Veterinario:</label>
            <select name="Usu_documento" id="Usu_documento" required>
                <option value="">Seleccionar</option>
                @foreach($veterinarians as $vet)
                <option value="{{ $vet->Usu_documento }}">{{ $vet->name }}</option>
                @endforeach
            </select>

            <label for="Cita_fecha">Fecha:</label>
            <input type="date" name="Cita_fecha" required>

            <label for="Cita_motivo">Motivo:</label>
            <input type="text" name="Cita_motivo" required>

            <button type="submit">Asignar Cita</button>
        </form>
    </div>

    @if($appointments->count() > 0)
    <h3>Citas Asignadas</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Animal</th>
                <th>Veterinario</th>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->animal->Anim_nombre ?? 'N/A' }}</td>
                <td>{{ $appointment->veterinarian->name ?? 'N/A' }}</td>
                <td>{{ $appointment->Cita_fecha }}</td>
                <td>{{ $appointment->Cita_motivo }}</td>
                <td>{{ $appointment->Cita_estado ?? 'Pendiente' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</main>
@endsection
