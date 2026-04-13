@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header-actions">
        <a href="{{ route('admin.dashboard') }}" class="fancy-btn secondary"><span>← Volver al Panel</span></a>
        <h2>Registro de Donaciones</h2>
        <p class="subtitle">Seguimiento de las contribuciones recibidas para el sustento de la fundación 💖</p>
    </div>

    @php 
        $total = $donations->sum('Don_monto');
        $count = $donations->count();
    @endphp

    <div class="stats-grid">
        <div class="stat-card box-shadow">
            <div class="stat-icon income">💰</div>
            <div class="stat-info">
                <span class="stat-label">Total Recaudado</span>
                <span class="stat-value">${{ number_format($total, 2) }}</span>
            </div>
        </div>
        <div class="stat-card box-shadow">
            <div class="stat-icon contributors">🤝</div>
            <div class="stat-info">
                <span class="stat-label">Donaciones Totales</span>
                <span class="stat-value">{{ $count }}</span>
            </div>
        </div>
        <div class="stat-card box-shadow">
            <div class="stat-icon avg">📈</div>
            <div class="stat-info">
                <span class="stat-label">Promedio por Donación</span>
                <span class="stat-value">${{ $count > 0 ? number_format($total / $count, 2) : '0.00' }}</span>
            </div>
        </div>
    </div>

    <div class="table-wrapper box-shadow">
        @if($donations->count() > 0)
        <table class="modern-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Donante</th>
                    <th>Fecha y Hora</th>
                    <th>Monto</th>
                    <th>Método de Pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donations as $donation)
                <tr>
                    <td><span class="id-tag">#{{ $donation->Don_id }}</span></td>
                    <td>
                        <div class="user-info-cell">
                            <div class="user-avatar-mini donor-theme">{{ substr($donation->user->name ?? 'A', 0, 1) }}</div>
                            <div>
                                <span class="user-name">{{ $donation->user->name ?? 'Anónimo' }}</span>
                                <span class="user-id">{{ $donation->user->email ?? 'Donante externo' }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="table-text-muted">
                            📅 {{ \Carbon\Carbon::parse($donation->Don_fecha)->format('d M, Y') }}<br>
                            <small>🕒 {{ \Carbon\Carbon::parse($donation->Don_fecha)->format('h:i A') }}</small>
                        </span>
                    </td>
                    <td>
                        <span class="amount-text">${{ number_format($donation->Don_monto, 2) }}</span>
                    </td>
                    <td>
                        <span class="payment-tag">{{ $donation->Don_metodo_pago }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <div class="stat-icon" style="font-size: 3rem; margin-bottom: 1rem;">🥀</div>
            <p>Aún no se han registrado donaciones en el sistema.</p>
        </div>
        @endif
    </div>
</div>

<style>
    .admin-container { padding: 2rem; max-width: 1200px; margin: 0 auto; }
    .admin-header-actions { margin-bottom: 2rem; text-align: center; }
    .admin-header-actions h2 { font-size: 2rem; color: #d81b60; margin: 1rem 0 0.5rem; }
    .subtitle { color: #666; font-size: 1.1rem; }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }
    .stat-icon.income { background: #e8f5e9; }
    .stat-icon.contributors { background: #e3f2fd; }
    .stat-icon.avg { background: #f3e5f5; }
    
    .stat-label { display: block; color: #888; font-size: 0.9rem; }
    .stat-value { display: block; font-size: 1.5rem; font-weight: bold; color: #333; }

    /* Table Styles (Sync with others) */
    .table-wrapper { background: white; border-radius: 15px; overflow: hidden; border: 1px solid #eee; }
    .box-shadow { box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: #fff8f9; padding: 1.2rem 1rem; text-align: left; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; color: #b71c1c; border-bottom: 2px solid #ffebee; }
    .modern-table td { padding: 1.2rem 1rem; border-bottom: 1px solid #f5f5f5; vertical-align: middle; }
    
    .id-tag { background: #f5f5f5; padding: 2px 8px; border-radius: 4px; font-family: monospace; font-size: 0.85rem; color: #666; }
    .user-info-cell { display: flex; align-items: center; gap: 1rem; }
    .user-avatar-mini.donor-theme { background: linear-gradient(135deg, #E91E63, #F06292); color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: bold; }
    .user-name { display: block; font-weight: 600; color: #333; }
    .user-id { font-size: 0.8rem; color: #888; }
    
    .amount-text { font-size: 1.1rem; font-weight: bold; color: #2e7d32; }
    .payment-tag { background: #f5f5f5; color: #555; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; border: 1px solid #ddd; }
    
    .table-text-muted { font-size: 0.85rem; color: #666; line-height: 1.4; }
    .empty-state { padding: 4rem; text-align: center; color: #999; }
</style>
@endsection
