@extends('layouts.app')

@section('panel-title', 'Pedidos | SDAANIM')

@section('content')
<div class="orders-container">
    <div class="orders-header-wrapper">
        <div class="orders-header">
            <div class="header-content">
                <a href="{{ route('admin.dashboard') }}" class="btn-back" title="Volver al Panel">
                    <span class="back-icon">←</span>
                </a>
                <div>
                    <h1>📦 Pedidos</h1>
                    <p class="subtitle">Listado de pedidos recibidos por el sistema y su estado de confirmación</p>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card stat-total">
            <div class="stat-icon total-icon">📋</div>
            <div class="stat-info">
                <span class="stat-label">Total</span>
                <span class="stat-value">{{ $orders->count() }} pedidos</span>
            </div>
        </div>
        <div class="stat-card stat-confirmed">
            <div class="stat-icon confirmed-icon">✅</div>
            <div class="stat-info">
                <span class="stat-label">Confirmados</span>
                <span class="stat-value">{{ $confirmedOrdersCount }}</span>
            </div>
        </div>
        <div class="stat-card stat-pending">
            <div class="stat-icon pending-icon">⏳</div>
            <div class="stat-info">
                <span class="stat-label">Pendientes</span>
                <span class="stat-value">{{ $pendingOrdersCount }}</span>
            </div>
        </div>
        <div class="stat-card stat-cancelled">
            <div class="stat-icon cancelled-icon">❌</div>
            <div class="stat-info">
                <span class="stat-label">Cancelados</span>
                <span class="stat-value">{{ $cancelledOrdersCount }}</span>
            </div>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <h3>No hay pedidos registrados</h3>
            <p>Aquí aparecerán los pedidos realizados por los usuarios cuando se generen.</p>
        </div>
    @else
        <div class="table-card">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Recogido</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="order-row">
                            <td>
                                <span class="id-badge">#{{ $order->ord_id }}</span>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar-mini">{{ substr(optional($order->user)->name ?? '?', 0, 1) }}</div>
                                    <span class="user-name">{{ optional($order->user)->name ?? 'Usuario eliminado' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="date-text">{{ optional($order->ord_fechaCreacion)->format('d/m/Y H:i') }}</span>
                            </td>
                            <td>
                                <span class="amount-text">${{ number_format($order->ord_total, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @if($order->ord_estado === 'recogido')
                                    <span class="status-badge confirmed">Confirmado</span>
                                @elseif($order->ord_estado === 'pendiente')
                                    <span class="status-badge pending">Pendiente</span>
                                @else
                                    <span class="status-badge cancelled">Cancelado</span>
                                @endif
                            </td>
                            <td>
                                <span class="date-text">{{ optional($order->ord_fechaRecogida)->format('d/m/Y H:i') ?? '-' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->ord_id) }}" class="btn-action view-btn">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .orders-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .orders-header-wrapper {
        margin-bottom: 2rem;
    }

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 0;
        flex: 1;
    }

    .header-content h1 {
        font-size: 2rem;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .subtitle {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
    }

    .btn-back {
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

    .btn-back:hover {
        background: #2e8b57;
        color: white;
        border-color: #2e8b57;
        transform: scale(1.1);
    }

    .back-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 1.2rem;
        border: 1px solid #eee;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        flex-shrink: 0;
    }

    .total-icon { background: #e8f5e9; }
    .confirmed-icon { background: #e0f2fe; }
    .pending-icon { background: #fef3c7; }
    .cancelled-icon { background: #fee2e2; }

    .stat-label {
        display: block;
        color: #888;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        display: block;
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    .table-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead {
        background: linear-gradient(135deg, #f8fbf8 0%, #f0f8f0 100%);
        border-bottom: 2px solid #e0e0e0;
    }

    .orders-table th {
        padding: 1.2rem 1.5rem;
        text-align: left;
        font-size: 0.85rem;
        font-weight: 700;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-row {
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s ease;
    }

    .order-row:hover {
        background-color: #f9faf9;
    }

    .orders-table td {
        padding: 1.2rem 1.5rem;
        vertical-align: middle;
    }

    .id-badge {
        background: #f5f5f5;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-family: monospace;
        font-size: 0.9rem;
        font-weight: 600;
        color: #555;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .user-avatar-mini {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2e8b57, #4caf50);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .user-name {
        font-weight: 600;
        color: #1a1a1a;
    }

    .date-text {
        color: #666;
        font-size: 0.9rem;
    }

    .amount-text {
        font-weight: 700;
        color: #2e8b57;
        font-size: 1rem;
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .status-badge.confirmed {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #b45309;
    }

    .status-badge.cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .view-btn {
        background: #e8f5e9;
        color: #2e8b57;
    }

    .view-btn:hover {
        background: #2e8b57;
        color: white;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.3rem;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
    }

    .empty-state p {
        color: #666;
        margin: 0;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .orders-container { padding: 1rem; }
        .header-content h1 { font-size: 1.5rem; }
        .stats-grid { grid-template-columns: 1fr 1fr; }
        .orders-table thead { display: none; }
        .order-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.8rem;
            padding: 1.5rem;
            border-bottom: 2px solid #f0f0f0;
        }
        .orders-table td {
            padding: 0.3rem 0;
            display: block;
            border: none;
        }
        .orders-table td:before {
            content: attr(data-label);
            font-weight: bold;
            color: #666;
            display: block;
            margin-bottom: 0.2rem;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
    }
</style>
@endsection
