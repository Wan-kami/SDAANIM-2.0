@extends(Auth::user()->role == 'Veterinario' ? 'layouts.vet.app' : 'layouts.volunteer.app')

@section('title', 'Mi Disponibilidad | SDAANIM')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/adopter/animals.css') }}">
@endsection

@section('content')
<div class="container">

    <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; background: #ffffff; color: #475569; padding: 10px 18px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.95em; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.borderColor='#cbd5e1'; this.style.transform='translateY(-1px)';" onmouseout="this.style.backgroundColor='#ffffff'; this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)';">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Volver al Panel
    </a>

    <!-- HEADER -->
    <div class="header">
        <h2>Mi Disponibilidad / Horario</h2>
    </div>

    <!-- ALERTAS -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORMULARIO AGREGAR -->
    <div class="card">
        <h3>Agregar Nuevo Horario</h3>

        <form action="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.availability.store' : 'volunteer.availability.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div>
                    <label>Fecha</label>
                    <input type="date" name="Ava_date" required min="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label>Hora Inicio</label>
                    <input type="time" name="Ava_start_time" required>
                </div>
                <div>
                    <label>Hora Fin</label>
                    <input type="time" name="Ava_end_time" required>
                </div>
            </div>
            <button type="submit" class="btn-primary">Guardar Disponibilidad</button>
        </form>
    </div>

    <!-- TABLA HORARIOS -->
    <h3>Mis Próximos Horarios</h3>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($availabilities as $ava)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($ava->Ava_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($ava->Ava_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($ava->Ava_end_time)->format('H:i') }}</td>
                    <td><span class="badge">{{ $ava->Ava_status }}</span></td>
                    <td style="text-align:center;">
                        <form action="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.availability.destroy' : 'volunteer.availability.destroy', $ava->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete" title="Eliminar">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:30px; color:#666;">
                        No has programado disponibilidad aún.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection