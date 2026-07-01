@extends('layouts.app')

@section('panel-title', 'Mi Disponibilidad')

@section('styles')
<style>
    .availability-page-container {
        padding: 0;
    }
    .availability-page-header {
        margin-bottom: 32px;
    }
    .availability-page-header h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        margin: 0 0 8px 0;
    }
    .availability-page-header p {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
    }
    .av-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    .av-card h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 24px 0;
    }
    .av-form-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }
    .av-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .av-form-group label {
        font-weight: 700;
        font-size: 0.85rem;
        color: #475569;
    }
    .av-form-group input {
        padding: 14px 18px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        background: #f8fafc;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.2s ease;
        outline: none;
        font-family: inherit;
    }
    .av-form-group input:focus {
        border-color: #16a34a;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
    }
    .av-btn-primary {
        background: #16a34a;
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);
    }
    .av-btn-primary:hover {
        background: #15803d;
        transform: translateY(-1px);
    }
    .av-btn-delete {
        background: transparent;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .av-btn-delete:hover {
        background: #fef2f2;
    }
    .av-table-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 20px 0;
    }
    .av-table-wrap {
        overflow-x: auto;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    .av-table {
        width: 100%;
        border-collapse: collapse;
    }
    .av-table thead th {
        text-align: left;
        padding: 16px 20px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    .av-table tbody td {
        padding: 14px 20px;
        font-size: 0.9rem;
        color: #475569;
        border-bottom: 1px solid #f1f5f9;
    }
    .av-table tbody tr:last-child td {
        border-bottom: none;
    }
    .av-table tbody tr:hover {
        background: #f8fafc;
    }
    .av-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        background: #f1f5f9;
        color: #475569;
    }
    .alert-success-custom {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-weight: 600;
    }
    .alert-error-custom {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
    }
    .alert-error-custom ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
    }
    .alert-error-custom li {
        margin: 4px 0;
    }
    .av-empty {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }
    @media (max-width: 768px) {
        .availability-page-container { padding: 20px 16px; }
        .av-form-grid { grid-template-columns: 1fr; }
        .av-card { padding: 20px; }
    }
</style>
@endsection

@section('content')
<div class="premium-dashboard-container">
    @include(Auth::user()->role == 'Veterinario' ? 'partials.vet_sidebar' : 'partials.volunteer_sidebar')

    <main class="dashboard-main-panel">
        <div class="availability-page-container">
            <div class="availability-page-header">
                <h1>Mi Disponibilidad / Horario</h1>
                <p>Gestiona los días y horas en que estarás disponible para el refugio.</p>
            </div>

            @if(session('success'))
                <div class="alert-success-custom">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert-error-custom">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="av-card">
                <h3>Agregar Nuevo Horario</h3>
                <form action="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.availability.store' : 'volunteer.availability.store') }}" method="POST">
                    @csrf
                    <div class="av-form-grid">
                        <div class="av-form-group">
                            <label>Fecha</label>
                            <input type="date" name="Ava_date" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="av-form-group">
                            <label>Hora Inicio</label>
                            <input type="time" name="Ava_start_time" required>
                        </div>
                        <div class="av-form-group">
                            <label>Hora Fin</label>
                            <input type="time" name="Ava_end_time" required>
                        </div>
                    </div>
                    <button type="submit" class="av-btn-primary">Guardar Disponibilidad</button>
                </form>
            </div>

            <h3 class="av-table-title">Mis Próximos Horarios</h3>

            <div class="av-table-wrap">
                <table class="av-table">
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
                            <td><span class="av-badge">{{ $ava->Ava_status }}</span></td>
                            <td style="text-align:center;">
                                <form action="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.availability.destroy' : 'volunteer.availability.destroy', $ava->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="av-btn-delete" title="Eliminar">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="av-empty">No has programado disponibilidad aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection