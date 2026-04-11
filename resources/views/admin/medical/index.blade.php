@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Historial Médico</h2>

    @if(session('success'))
    <p class="mensaje">{{ session('success') }}</p>
    @endif

    @if($histories->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Animal</th>
                <th>Veterinario</th>
                <th>Fecha</th>
                <th>Diagnóstico</th>
                <th>Tratamiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
            <tr>
                <td>{{ $history->Hist_id }}</td>
                <td>{{ $history->animal->Anim_nombre ?? 'N/A' }}</td>
                <td>{{ $history->veterinarian->name ?? 'N/A' }}</td>
                <td>{{ $history->Hist_fecha ? \Carbon\Carbon::parse($history->Hist_fecha)->format('d/m/Y H:i') : 'N/A' }}</td>
                <td>{{ Str::limit($history->Hist_diagnostico, 50) }}</td>
                <td>{{ Str::limit($history->Hist_tratamiento, 50) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-users">No hay historiales médicos registrados.</p>
    @endif
</main>
@endsection
