@extends('layouts.app')

@section('content')
<main class="notifications-main">
    <!-- Professional Header -->
    <div class="notifications-header-wrapper">
        <a href="{{ route('admin.dashboard') }}" class="btn-back-notifications" title="Volver al Panel">
            <span class="back-icon-notifications">←</span>
        </a>
        <div class="notifications-header-content">
            <h1>🔔 Todas las Notificaciones</h1>
            <p class="notifications-subtitle">Centro de gestión de notificaciones del sistema</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success-notif">
        <span class="alert-icon-notif">✅</span>
        <p class="mensaje-notif">{{ session('success') }}</p>
    </div>
    @endif

    @if($notifications->count() > 0)
    <div class="notifications-card">
        <div class="notifications-stats">
            <span class="total-badge">Total: {{ $notifications->count() }} notificaciones</span>
        </div>
        <div class="table-wrapper-notif">
            <table class="notifications-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $notification)
                    <tr class="notification-row">
                        <td class="td-id"><span class="id-badge">#{{ $notification->Noto_id }}</span></td>
                        <td class="td-usuario">{{ $notification->Usu_documento }}</td>
                        <td class="td-mensaje">{{ $notification->Noti_mensaje }}</td>
                        <td class="td-fecha">
                            <span class="date-badge">{{ $notification->created_at->format('d/m/Y') }}</span>
                            <span class="time-text">{{ $notification->created_at->format('H:i') }}</span>
                        </td>
                        <td class="td-acciones">
                            @if($notification->Noti_link)
                            <a href="{{ $notification->Noti_link }}" class="btn-action btn-ver">Ver</a>
                            @endif
                            <a href="{{ route('admin.notifications.delete', $notification->Noto_id) }}" class="btn-action btn-eliminar" onclick="return confirm('¿Eliminar esta notificación?')">Eliminar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="empty-state-notif">
        <div class="empty-icon-notif">🔔</div>
        <h3>No hay notificaciones</h3>
        <p>Actualmente no hay notificaciones en el sistema.</p>
    </div>
    @endif
</main>

<style>
    .notifications-main {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Professional Header */
    .notifications-header-wrapper {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 2rem;
    }

    .notifications-header-content {
        flex: 1;
    }

    .notifications-header-content h1 {
        font-size: 2rem;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .notifications-subtitle {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
        text-align: left;
    }

    /* Back Button */
    .btn-back-notifications {
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
        flex-shrink: 0;
    }

    .btn-back-notifications:hover {
        background: #4CAF50;
        color: white;
        border-color: #4CAF50;
        transform: scale(1.1);
    }

    .back-icon-notifications {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Alert Success */
    .alert-success-notif {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        border-left: 4px solid #4CAF50;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-icon-notif {
        font-size: 1.5rem;
    }

    .mensaje-notif {
        color: #2e7d32;
        font-weight: 500;
        margin: 0;
    }

    /* Notifications Card */
    .notifications-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #eee;
        overflow: hidden;
    }

    .notifications-stats {
        background: linear-gradient(135deg, #f5f5f5, #fafafa);
        padding: 1.2rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .total-badge {
        background: #4CAF50;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Table Wrapper */
    .table-wrapper-notif {
        overflow-x: auto;
    }

    .notifications-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.95rem;
    }

    .notifications-table thead {
        background: #2e8b57;
        color: white;
    }

    .notifications-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .notifications-table td {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        color: #333;
    }

    .notification-row:hover {
        background: #f8fafb;
    }

    .td-id {
        width: 80px;
    }

    .id-badge {
        background: #e3f2fd;
        color: #1976d2;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .td-usuario {
        width: 150px;
        font-weight: 500;
        color: #2e8b57;
    }

    .td-mensaje {
        flex: 1;
        max-width: 400px;
        color: #555;
    }

    .td-fecha {
        width: 180px;
    }

    .date-badge {
        background: #fff3e0;
        color: #e65100;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
        margin-right: 0.5rem;
    }

    .time-text {
        color: #888;
        font-size: 0.85rem;
    }

    .td-acciones {
        width: 180px;
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
    }

    .btn-ver {
        background: #2196F3;
        color: white;
    }

    .btn-ver:hover {
        background: #1976d2;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(33, 150, 243, 0.3);
    }

    .btn-eliminar {
        background: #dc3545;
        color: white;
    }

    .btn-eliminar:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    /* Empty State */
    .empty-state-notif {
        background: white;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #eee;
    }

    .empty-icon-notif {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state-notif h3 {
        color: #333;
        font-size: 1.5rem;
        margin: 0 0 0.5rem 0;
    }

    .empty-state-notif p {
        color: #888;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .td-mensaje {
            max-width: 250px;
        }
    }

    @media (max-width: 768px) {
        .notifications-main {
            padding: 1rem;
        }

        .notifications-header-wrapper {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .notifications-header-content h1 {
            font-size: 1.5rem;
        }

        .table-wrapper-notif {
            overflow-x: auto;
        }

        .notifications-table {
            font-size: 0.85rem;
        }

        .notifications-table th,
        .notifications-table td {
            padding: 0.75rem;
        }

        .td-mensaje {
            max-width: 150px;
        }

        .td-acciones {
            flex-direction: column;
            width: auto;
        }

        .btn-action {
            width: 100%;
        }
    }
</style>

@endsection
