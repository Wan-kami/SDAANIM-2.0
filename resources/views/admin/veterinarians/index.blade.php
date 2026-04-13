@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header-actions">
        <a href="{{ route('admin.dashboard') }}" class="fancy-btn secondary"><span>← Volver al Panel</span></a>
        <h2>Gestión de Veterinarios</h2>
        <p class="subtitle">Administra las solicitudes de profesionales veterinarios que desean colaborar 🏥🐾</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <div class="alert-icon">✅</div>
        <div class="alert-message">{{ session('success') }}</div>
    </div>
    @endif

    <div class="table-wrapper box-shadow">
        @if($veterinarians->count() > 0)
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Especialista</th>
                    <th>Contacto</th>
                    <th>Ubicación</th>
                    <th width="150">Experiencia</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($veterinarians as $vet)
                <tr>
                    <td>
                        <div class="user-info-cell">
                            <div class="user-avatar-mini vet-theme">{{ substr($vet->ins_nombre, 0, 1) }}</div>
                            <div>
                                <span class="user-name">{{ $vet->ins_nombre }}</span>
                                <span class="user-id">Tarjeta Prof: {{ $vet->ins_tarjeta_profesional ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="contact-info-cell">
                            <span>📧 {{ $vet->ins_email }}</span>
                            <span>📱 {{ $vet->ins_telefono }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="location-text">📍 {{ $vet->ins_direccion }}</span>
                    </td>
                    <td>
                        <span class="experience-tag">{{ $vet->ins_experiencia ?? 'General' }}</span>
                    </td>
                    <td>
                        @if($vet->ins_estado == 'Pendiente')
                            <span class="status-badge warning">Pendiente</span>
                        @elseif($vet->ins_estado == 'Aprobada')
                            <span class="status-badge success">Activo</span>
                        @else
                            <span class="status-badge danger">Rechazada</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            @if($vet->ins_estado == 'Pendiente')
                            <form action="{{ route('admin.veterinarians.process') }}" method="POST" class="inline-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $vet->ins_id }}">
                                <input type="hidden" name="accion" value="aceptar">
                                <button type="submit" class="btn-icon approve" title="Aceptar Veterinario">
                                    <i class="fas fa-user-md"></i> Aceptar
                                </button>
                            </form>
                            <form action="{{ route('admin.veterinarians.process') }}" method="POST" class="inline-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $vet->ins_id }}">
                                <input type="hidden" name="accion" value="rechazar">
                                <button type="submit" class="btn-icon reject" title="Rechazar Veterinario">
                                    <i class="fas fa-user-slash"></i> Rechazar
                                </button>
                            </form>
                            @else
                                <span class="text-muted">Procesada</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <img src="{{ asset('img/empty-vet.png') }}" alt="No hay veterinarios" style="width: 150px; opacity: 0.5;">
            <p>No hay solicitudes de veterinarios pendientes.</p>
        </div>
        @endif
    </div>
</div>

<style>
    /* Premium Modern Table Styles (Sync with Volunteers) */
    .admin-container { padding: 2rem; max-width: 1200px; margin: 0 auto; }
    .admin-header-actions { margin-bottom: 2rem; text-align: center; }
    .admin-header-actions h2 { font-size: 2rem; color: #1976d2; margin: 1rem 0 0.5rem; }
    .subtitle { color: #666; font-size: 1.1rem; }
    .table-wrapper { background: white; border-radius: 15px; overflow: hidden; border: 1px solid #eee; }
    .box-shadow { box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: #f8fbff; padding: 1.2rem 1rem; text-align: left; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; color: #555; border-bottom: 2px solid #eef6ff; }
    .modern-table td { padding: 1.2rem 1rem; border-bottom: 1px solid #f5f5f5; vertical-align: middle; }
    
    .user-info-cell { display: flex; align-items: center; gap: 1rem; }
    .user-avatar-mini { width: 40px; height: 40px; background: linear-gradient(135deg, #2196F3, #64B5F6); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; }
    .user-avatar-mini.vet-theme { background: linear-gradient(135deg, #009688, #4DB6AC); }
    .user-name { display: block; font-weight: 600; color: #333; }
    .user-id { font-size: 0.8rem; color: #888; }
    
    .contact-info-cell span { display: block; font-size: 0.85rem; color: #555; margin-bottom: 0.2rem; }
    .location-text { font-size: 0.85rem; color: #666; }
    .experience-tag { background: #e0f2f1; color: #00796b; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; }
    
    .status-badge { padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; }
    .status-badge.warning { background: #fff8e1; color: #f57c00; }
    .status-badge.success { background: #e8f5e9; color: #2e7d32; }
    .status-badge.danger { background: #ffebee; color: #c62828; }

    .action-buttons { display: flex; gap: 0.5rem; }
    .btn-icon { padding: 8px 12px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.85rem; transition: all 0.2s; display: flex; align-items: center; gap: 5px; }
    .btn-icon.approve { background: #009688; color: white; }
    .btn-icon.approve:hover { background: #00796b; transform: translateY(-2px); }
    .btn-icon.reject { background: #f44336; color: white; }
    .btn-icon.reject:hover { background: #d32f2f; transform: translateY(-2px); }

    .alert { display: flex; padding: 1rem; border-radius: 10px; margin-bottom: 2rem; align-items: center; border-left: 5px solid #4CAF50; background: #e8f5e9; }
    .alert-icon { font-size: 1.5rem; margin-right: 1rem; }
    .alert-message { font-weight: 500; color: #2e7d32; }
    .empty-state { padding: 4rem; text-align: center; color: #999; }
</style>
@endsection
