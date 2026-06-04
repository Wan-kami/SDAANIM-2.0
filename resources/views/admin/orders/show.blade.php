@extends('layouts.app')

@section('panel-title', 'Detalle de Pedido | SDAANIM')

@section('content')
<div class="order-detail-container">
    <div class="order-detail-header-wrapper">
        <div class="order-detail-header">
            <div class="header-content">
                <a href="{{ route('admin.orders') }}" class="btn-back" title="Volver a Pedidos">
                    <span class="back-icon">←</span>
                </a>
                <div>
                    <h1>Pedido #{{ $order->ord_id }}</h1>
                    <p class="subtitle">Detalle del pedido realizado por {{ optional($order->user)->name ?? 'Usuario eliminado' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✅</span>
            <span class="alert-message">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <span class="alert-icon">⚠️</span>
            <span class="alert-message">{{ session('error') }}</span>
        </div>
    @endif

    <div class="info-grid">
        <div class="info-card">
            <div class="info-card-icon client-icon">👤</div>
            <div class="info-card-body">
                <span class="info-label">Cliente</span>
                <span class="info-value">{{ optional($order->user)->name ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-icon email-icon">📧</div>
            <div class="info-card-body">
                <span class="info-label">Email</span>
                <span class="info-value">{{ optional($order->user)->email ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-icon date-icon">📅</div>
            <div class="info-card-body">
                <span class="info-label">Fecha de creación</span>
                <span class="info-value">{{ optional($order->ord_fechaCreacion)->format('d/m/Y H:i') }}</span>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-icon total-icon-show">💰</div>
            <div class="info-card-body">
                <span class="info-label">Total</span>
                <span class="info-value total-amount">${{ number_format($order->ord_total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h3>🛒 Productos del Pedido</h3>
        </div>
        <table class="detail-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr class="detail-row">
                        <td>
                            <span class="product-name">{{ optional($item->product)->prod_nombre ?? 'Producto no disponible' }}</span>
                        </td>
                        <td>
                            <span class="quantity-badge">{{ $item->oit_cantidad }}</span>
                        </td>
                        <td>
                            <span class="price-text">${{ number_format($item->oit_precio_unitario, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span class="subtotal-text">${{ number_format($item->oit_subtotal, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="order-footer">
        <div class="order-status-info">
            <div class="status-item">
                <span class="status-label">Estado:</span>
                @if($order->ord_estado === 'recogido')
                    <span class="status-badge confirmed">Confirmado</span>
                @elseif($order->ord_estado === 'pendiente')
                    <span class="status-badge pending">Pendiente</span>
                @else
                    <span class="status-badge cancelled">Cancelado</span>
                @endif
            </div>
            <div class="status-item">
                <span class="status-label">Fecha de recogida:</span>
                <span class="status-value">{{ optional($order->ord_fechaRecogida)->format('d/m/Y H:i') ?? 'No registrada' }}</span>
            </div>
        </div>

        @if($order->ord_estado === 'pendiente')
            <div class="action-buttons">
                <form action="{{ route('admin.orders.pickup', $order->ord_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-action btn-confirm">
                        <span>✅</span> Marcar como recogido
                    </button>
                </form>
                <form action="{{ route('admin.orders.cancel', $order->ord_id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar este pedido?')">
                    @csrf
                    <button type="submit" class="btn-action btn-cancel-order">
                        <span>❌</span> Cancelar pedido
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .order-detail-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .order-detail-header-wrapper {
        margin-bottom: 2rem;
    }

    .order-detail-header {
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

    .alert {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        border-left: 5px solid;
    }

    .alert-success {
        background: #e8f5e9;
        border-color: #2e7d32;
    }

    .alert-error {
        background: #fee2e2;
        border-color: #b91c1c;
    }

    .alert-icon {
        font-size: 1.3rem;
    }

    .alert-message {
        font-weight: 600;
        color: #1a1a1a;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 1.2rem;
        border: 1px solid #eee;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .info-card-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        flex-shrink: 0;
    }

    .client-icon { background: #e8f5e9; }
    .email-icon { background: #e0f2fe; }
    .date-icon { background: #fef3c7; }
    .total-icon-show { background: #f3e5f5; }

    .info-card-body {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .info-label {
        font-size: 0.85rem;
        color: #888;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 0.3rem;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        white-space: normal;
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    .total-amount {
        color: #2e8b57;
    }

    .table-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .table-header {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid #e0e0e0;
        background: linear-gradient(135deg, #f8fbf8 0%, #f0f8f0 100%);
    }

    .table-header h3 {
        margin: 0;
        font-size: 1.1rem;
        color: #1a1a1a;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-table thead {
        background: #f8fbf8;
        border-bottom: 2px solid #e0e0e0;
    }

    .detail-table th {
        padding: 1.2rem 1.5rem;
        text-align: left;
        font-size: 0.85rem;
        font-weight: 700;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-row {
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s ease;
    }

    .detail-row:hover {
        background-color: #f9faf9;
    }

    .detail-table td {
        padding: 1.2rem 1.5rem;
        vertical-align: middle;
    }

    .product-name {
        font-weight: 600;
        color: #1a1a1a;
    }

    .quantity-badge {
        display: inline-block;
        background: #e8f5e9;
        color: #2e8b57;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .price-text {
        color: #666;
        font-weight: 500;
    }

    .subtotal-text {
        font-weight: 700;
        color: #2e8b57;
    }

    .order-footer {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .order-status-info {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .status-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .status-label {
        font-weight: 600;
        color: #555;
        font-size: 0.95rem;
    }

    .status-value {
        color: #666;
        font-size: 0.95rem;
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

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-confirm {
        background: #047857;
        color: white;
    }

    .btn-confirm:hover {
        background: #065f46;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(4, 120, 87, 0.3);
    }

    .btn-cancel-order {
        background: #dc2626;
        color: white;
    }

    .btn-cancel-order:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    @media (max-width: 768px) {
        .order-detail-container { padding: 1rem; }
        .header-content h1 { font-size: 1.5rem; }
        .info-grid { grid-template-columns: 1fr; }
        .order-footer { flex-direction: column; align-items: flex-start; }
        .action-buttons { width: 100%; }
        .btn-action { flex: 1; justify-content: center; }
    }
</style>
@endsection
