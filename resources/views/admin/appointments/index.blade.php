@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header-actions">
        <a href="{{ route('admin.dashboard') }}" class="fancy-btn secondary"><span>← Volver al Panel</span></a>
        <h2>Gestión de Citas Médicas</h2>
        <p class="subtitle">Coordina las revisiones y tratamientos de nuestros rescatados con los especialistas 🩺🐾</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <div class="alert-icon">📅</div>
        <div class="alert-message">{{ session('success') }}</div>
    </div>
    @endif

    <div class="layout-grid">
        <!-- Form Side -->
        <div class="side-form box-shadow">
            <h3>📅 Programar Nueva Cita</h3>
            <form action="{{ route('admin.appointments.store') }}" method="POST" class="modern-form">
                @csrf
                <div class="form-group">
                    <label for="Anim_id">Paciente (Mascota)</label>
                    <select name="Anim_id" id="Anim_id" class="form-control" required>
                        <option value="">Seleccionar mascota...</option>
                        @foreach($animals as $animal)
                        <option value="{{ $animal->Anim_id }}">{{ $animal->Anim_nombre }} ({{ $animal->Anim_raza }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="Usu_documento">Veterinario Asignado</label>
                    <select name="Usu_documento" id="Usu_documento" class="form-control" required>
                        <option value="">Seleccionar especialista...</option>
                        @foreach($veterinarians as $vet)
                        <option value="{{ $vet->Usu_documento }}">{{ $vet->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="Cita_fecha">Fecha y Hora</label>
                    <input type="datetime-local" name="Cita_fecha" id="Cita_fecha" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="Cita_motivo">Motivo de la Consulta</label>
                    <textarea name="Cita_motivo" id="Cita_motivo" class="form-control" rows="3" placeholder="Ej: Vacunación anual, revisión post-operatoria..." required></textarea>
                </div>

                <button type="submit" class="btn-primary-gradient">Agendar Cita Médica</button>
            </form>
        </div>

        <!-- List Side -->
        <div class="main-list">
            <div class="table-wrapper box-shadow">
                <div class="table-header">
                    <h3>📋 Citas Programadas</h3>
                </div>
                @if($appointments->count() > 0)
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Mascota</th>
                            <th>Especialista</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="item-info">
                                    <span class="item-main">{{ $appointment->animal->Anim_nombre ?? 'N/A' }}</span>
                                    <span class="item-sub">{{ $appointment->Cita_motivo }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="item-info">
                                    <span class="item-main">{{ $appointment->veterinarian->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="date-cell">
                                    <span class="date-main">{{ \Carbon\Carbon::parse($appointment->Cita_fecha)->format('d/m/Y') }}</span>
                                    <span class="date-sub">{{ \Carbon\Carbon::parse($appointment->Cita_fecha)->format('H:i A') }}</span>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('admin.appointments.updateStatus', $appointment->Cita_id) }}" method="POST" class="status-form">
                                    @csrf
                                    <select name="Cita_estado" onchange="this.form.submit()" class="status-select {{ strtolower($appointment->Cita_estado) }}">
                                        <option value="Pendiente" {{ $appointment->Cita_estado == 'Pendiente' ? 'selected' : '' }}>🕒 Pendiente</option>
                                        <option value="Completada" {{ $appointment->Cita_estado == 'Completada' ? 'selected' : '' }}>✅ Completada</option>
                                        <option value="Cancelada" {{ $appointment->Cita_estado == 'Cancelada' ? 'selected' : '' }}>❌ Cancelada</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <!-- Aquí se podrían añadir botones de historial médico directamente -->
                                    <span class="id-tag">#{{ $appointment->Cita_id }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <p>No hay citas médicas programadas por el momento.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .admin-container { padding: 2rem; max-width: 1300px; margin: 0 auto; }
    .admin-header-actions { margin-bottom: 2.5rem; text-align: center; }
    .admin-header-actions h2 { font-size: 2.2rem; color: #00796b; margin: 1rem 0 0.5rem; }
    .subtitle { color: #666; font-size: 1.1rem; }

    .layout-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 2rem;
        align-items: start;
    }

    /* Form Styles */
    .side-form {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        position: sticky;
        top: 2rem;
    }
    .side-form h3 { margin-top: 0; color: #333; font-size: 1.25rem; margin-bottom: 1.5rem; border-bottom: 2px solid #f0f0f0; padding-bottom: 0.5rem; }
    .form-group { margin-bottom: 1.2rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #555; font-size: 0.9rem; }
    .form-control {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: border-color 0.2s;
    }
    .form-control:focus { outline: none; border-color: #00796b; background: #f0f8f7; }
    .btn-primary-gradient {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, #00796b, #004d40);
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .btn-primary-gradient:hover { transform: translateY(-2px); opacity: 0.95; }

    /* Table & List Styles */
    .table-wrapper { background: white; border-radius: 15px; overflow: hidden; }
    .table-header { padding: 1.5rem; border-bottom: 1px solid #f0f0f0; }
    .table-header h3 { margin: 0; font-size: 1.2rem; color: #333; }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: #f8fbfb; padding: 1.2rem 1.5rem; text-align: left; font-size: 0.85rem; color: #555; text-transform: uppercase; }
    .modern-table td { padding: 1.2rem 1.5rem; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }

    .item-info { display: flex; flex-direction: column; }
    .item-main { font-weight: 600; color: #333; }
    .item-sub { font-size: 0.8rem; color: #888; }

    .date-cell { display: flex; flex-direction: column; }
    .date-main { font-weight: 500; color: #333; }
    .date-sub { font-size: 0.75rem; color: #00796b; font-weight: bold; }

    .status-select {
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        border: 1px solid transparent;
        cursor: pointer;
        font-weight: 600;
    }
    .status-select.pendiente { background: #fff8e1; color: #f57c00; }
    .status-select.completada { background: #e8f5e9; color: #2e7d32; }
    .status-select.cancelada { background: #ffebee; color: #c62828; }

    .id-tag { background: #f5f5f5; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; color: #aaa; }
    .box-shadow { box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .alert { display: flex; padding: 1rem; border-radius: 10px; margin-bottom: 2rem; align-items: center; border-left: 5px solid #00796b; background: #e0f2f1; }
    .alert-icon { font-size: 1.5rem; margin-right: 1rem; }
    .alert-message { font-weight: 500; color: #004d40; }
    
    @media (max-width: 992px) {
        .layout-grid { grid-template-columns: 1fr; }
        .side-form { position: static; }
    }
</style>
@endsection
