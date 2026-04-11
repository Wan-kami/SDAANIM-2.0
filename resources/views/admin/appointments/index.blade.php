@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Citas Veterinarias</h2>

    @if(session('success'))
    <p class="mensaje">{{ session('success') }}</p>
    @endif

    <div class="form-container" style="width: 100%; max-width: 600px;">
        <h3>Asignar Nueva Cita</h3>
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

            <label for="Cita_fecha">Fecha y Hora:</label>
            <input type="datetime-local" name="Cita_fecha" id="Cita_fecha" required>

            <label for="Cita_motivo">Motivo:</label>
            <input type="text" name="Cita_motivo" id="Cita_motivo" placeholder="Ej. Vacuna, Revision general" required>

            <button type="submit">Asignar Cita</button>
        </form>
    </div>

    @if($appointments->count() > 0)
    <h3 style="margin-top: 40px;">Citas Asignadas</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Animal</th>
                <th>Veterinario</th>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->Cita_id }}</td>
                <td>{{ $appointment->animal->Anim_nombre ?? 'N/A' }}</td>
                <td>{{ $appointment->veterinarian->name ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($appointment->Cita_fecha)->format('d/m/Y H:i') }}</td>
                <td>{{ $appointment->Cita_motivo }}</td>
                <td>
                    <form action="{{ route('admin.appointments.updateStatus', $appointment->Cita_id) }}" method="POST" style="display:inline;">
                        @csrf
                        <select name="Cita_estado" onchange="this.form.submit()" style="padding: 5px; border-radius: 4px;">
                            <option value="Pendiente" {{ $appointment->Cita_estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Completada" {{ $appointment->Cita_estado == 'Completada' ? 'selected' : '' }}>Completada</option>
                            <option value="Cancelada" {{ $appointment->Cita_estado == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </form>
                </td>
                <td>
                    <a href="{{ route('admin.appointments') }}" class="btn-cancel" style="padding: 5px 10px;">Ver</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</main>
@endsection
