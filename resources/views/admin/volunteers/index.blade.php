@extends('layouts.app')

@section('content')
<div class="admin-container">
    <!-- Professional Header -->
    <div class="professional-header">
        <div class="header-content-vol">
            <a href="{{ route('admin.dashboard') }}" class="btn-back-vol" title="Volver al Panel">
                <span class="back-icon-vol">←</span>
            </a>
            <div>
                <h1>👥 Gestión de Voluntarios</h1>
                <p class="subtitle">Revisa y procesa las solicitudes de personas que quieren ayudar a la fundación</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <div class="alert-icon">✅</div>
        <div class="alert-message">{{ session('success') }}</div>
    </div>
    @endif

    @if($volunteers->count() > 0)
    <div style="margin-bottom: 3rem;">
        <h3 style="font-size: 1.3rem; color: #4CAF50; margin-bottom: 1.5rem;">✓ Voluntarios Activos ({{ $volunteers->count() }})</h3>
        <div class="table-wrapper box-shadow">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($volunteers as $vol)
                    <tr>
                        <td>
                            <div class="user-info-cell">
                                <div class="user-avatar-mini">{{ substr($vol->name, 0, 1) }}</div>
                                <div>
                                    <span class="user-name">{{ $vol->name }}</span>
                                    <span class="user-id">CC: {{ $vol->Usu_documento }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="contact-info-cell">
                                <span>📧 {{ $vol->email }}</span>
                                <span>📱 {{ $vol->Usu_telefono }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge success">{{ $vol->status }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if($vol->status === 'Activo')
                                <form action="{{ route('admin.users.deactivate', $vol->Usu_documento) }}" method="POST" class="inline-form" onsubmit="return confirm('¿Desactivar este voluntario?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-icon reject">
                                        <i class="fas fa-ban"></i> Desactivar
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.users.activate', $vol->Usu_documento) }}" method="POST" class="inline-form" onsubmit="return confirm('¿Activar este voluntario?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-icon approve">
                                        <i class="fas fa-check"></i> Activar
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($inscriptions->count() > 0)
    <div>
        <h3 style="font-size: 1.3rem; color: #1976d2; margin-bottom: 1.5rem;">⏳ Solicitudes Pendientes ({{ $inscriptions->count() }})</h3>
        <div class="table-wrapper box-shadow">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Postulante</th>
                        <th>Contacto</th>
                        <th>Tipo de Ayuda</th>
                        <th width="200">Comentario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscriptions as $vol)
                    <tr>
                        <td>
                            <div class="user-info-cell">
                                <div class="user-avatar-mini">{{ substr($vol->ins_nombre, 0, 1) }}</div>
                                <div>
                                    <span class="user-name">{{ $vol->ins_nombre }}</span>
                                    <span class="user-id">CC: {{ $vol->ins_documento }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="contact-info-cell">
                                <span>📧 {{ $vol->ins_email }}</span>
                                <span>📱 {{ $vol->ins_telefono }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="category-tag">{{ $vol->ins_tipo_ayuda }}</span>
                        </td>
                        <td>
                            <p class="table-text-muted" title="{{ $vol->ins_comentario }}">
                                {{ Str::limit($vol->ins_comentario, 60) }}
                            </p>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <form action="{{ route('admin.volunteers.process') }}" method="POST" class="inline-form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $vol->ins_id }}">
                                    <input type="hidden" name="accion" value="aceptar">
                                    <button type="submit" class="btn-icon approve" title="Aceptar Postulación">
                                        <i class="fas fa-check"></i> Aceptar
                                    </button>
                                </form>
                                <form action="{{ route('admin.volunteers.process') }}" method="POST" class="inline-form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $vol->ins_id }}">
                                    <input type="hidden" name="accion" value="rechazar">
                                    <button type="submit" class="btn-icon reject" title="Rechazar Postulación">
                                        <i class="fas fa-times"></i> Rechazar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @elseif($volunteers->count() == 0)
    <div class="empty-state">
        <img src="{{ asset('img/empty-volunteers.png') }}" alt="No hay voluntarios" style="width: 150px; opacity: 0.5;">
        <p>No hay voluntarios registrados actualmente.</p>
    </div>
    @endif
</div>

<style>
    /* Premium Modern Table Styles */
    .admin-container {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    .admin-header-actions {
        margin-bottom: 2rem;
        text-align: center;
    }
    .admin-header-actions h2 {
        font-size: 2rem;
        color: #2e7d32;
        margin: 1rem 0 0.5rem;
    }
    .subtitle {
        color: #666;
        font-size: 1.1rem;
    }
    .table-wrapper {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #eee;
    }
    .box-shadow {
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }
    .modern-table th {
        background: #f8fbf8;
        padding: 1.2rem 1rem;
        text-align: left;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #555;
        border-bottom: 2px solid #eef2ee;
    }
    .modern-table td {
        padding: 1.2rem 1rem;
        border-bottom: 1px solid #f5f5f5;
        vertical-align: middle;
    }
    .user-info-cell {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .user-avatar-mini {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #4CAF50, #81C784);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }
    .user-name {
        display: block;
        font-weight: 600;
        color: #333;
    }
    .user-id {
        font-size: 0.8rem;
        color: #888;
    }
    .contact-info-cell span {
        display: block;
        font-size: 0.85rem;
        color: #555;
        margin-bottom: 0.2rem;
    }
    .category-tag {
        background: #e3f2fd;
        color: #1976d2;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .table-text-muted {
        font-size: 0.85rem;
        color: #777;
        margin: 0;
    }
    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
    }
    .status-badge.warning { background: #fff8e1; color: #f57c00; }
    .status-badge.success { background: #e8f5e9; color: #2e7d32; }
    .status-badge.danger { background: #ffebee; color: #c62828; }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    .btn-icon {
        padding: 8px 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .btn-icon.approve { background: #4CAF50; color: white; }
    .btn-icon.approve:hover { background: #388E3C; transform: translateY(-2px); }
    .btn-icon.reject { background: #f44336; color: white; }
    .btn-icon.reject:hover { background: #d32f2f; transform: translateY(-2px); }

    .alert {
        display: flex;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        align-items: center;
        border-left: 5px solid #4CAF50;
        background: #e8f5e9;
    }
    .alert-icon { font-size: 1.5rem; margin-right: 1rem; }
    .alert-message { font-weight: 500; color: #2e7d32; }

    .empty-state {
        padding: 4rem;
        text-align: center;
        color: #999;
    }
    .inline-form {
        display: inline;
    }

    /* Professional Header Styles */
    .professional-header {
        margin-bottom: 2rem;
    }

    .header-content-vol {
        display: flex;
        align-items: center;
        gap: 0;
    }

    .header-content-vol h1 {
        font-size: 2rem;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .header-content-vol .subtitle {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
    }

    /* Back Button */
    .btn-back-vol {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #f0f0f0;
        color: #333;
        text-decoration: none;
        border-radius: 50%;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-right: 1rem;
        font-size: 1.2rem;
        border: 2px solid #e0e0e0;
    }

    .btn-back-vol:hover {
        background: #4CAF50;
        color: white;
        border-color: #4CAF50;
        transform: scale(1.1);
    }

    .back-icon-vol {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
