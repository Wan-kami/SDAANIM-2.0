@extends('layouts.app')

@section('panel-title', 'Notificaciones')

@section('styles')
<style>
    .notif-page-container {
        padding: 0;
    }
    .notif-page-header {
        margin-bottom: 32px;
    }
    .notif-page-header h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        margin: 0 0 8px 0;
    }
    .notif-page-header p {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
    }
    .notif-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        border-left: 5px solid #0ea5e9;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        transition: all 0.2s ease;
    }
    .notif-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }
    .notif-card-content {
        flex: 1;
    }
    .notif-card-message {
        margin: 0 0 8px 0;
        color: #1e293b;
        font-weight: 600;
        font-size: 0.95rem;
    }
    .notif-card-date {
        margin: 0;
        font-size: 0.85rem;
        color: #64748b;
    }
    .notif-card-link {
        display: inline-block;
        margin-top: 10px;
        color: #0ea5e9;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: color 0.2s;
    }
    .notif-card-link:hover {
        color: #0284c7;
    }
    .notif-delete-btn {
        background: none;
        border: none;
        font-size: 1.3rem;
        cursor: pointer;
        color: #94a3b8;
        padding: 4px 8px;
        border-radius: 8px;
        transition: all 0.2s ease;
        margin-left: 16px;
        flex-shrink: 0;
    }
    .notif-delete-btn:hover {
        color: #ef4444;
        background: #fef2f2;
    }
    .notif-empty {
        text-align: center;
        padding: 60px 20px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    .notif-empty p {
        font-size: 1.1rem;
        color: #64748b;
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
    @media (max-width: 768px) {
        .notif-page-container { padding: 20px 16px; }
    }
</style>
@endsection

@section('content')
<div class="premium-dashboard-container">
    @include(Auth::user()->role == 'Veterinario' ? 'partials.vet_sidebar' : 'partials.volunteer_sidebar')

    <main class="dashboard-main-panel">
        <div class="notif-page-container">
            <div class="notif-page-header">
                <h1>Centro de Notificaciones</h1>
                <p>Todas tus actividades y actualizaciones en un solo lugar.</p>
            </div>

            @if(session('success'))
                <div class="alert-success-custom">{{ session('success') }}</div>
            @endif

            @if($notifications->isEmpty())
                <div class="notif-empty">
                    <p>📭 No tienes notificaciones</p>
                </div>
            @else
                <div>
                    @foreach($notifications as $notif)
                        <div class="notif-card">
                            <div class="notif-card-content">
                                <p class="notif-card-message">{{ $notif->Noti_mensaje }}</p>
                                <p class="notif-card-date"><strong>Fecha:</strong> {{ $notif->Noti_fecha ? $notif->Noti_fecha->format('d/m/Y') : '-' }}</p>
                                @if($notif->Noti_link)
                                    <a href="{{ $notif->Noti_link }}" class="notif-card-link">Ver más →</a>
                                @endif
                            </div>
                            <form action="{{ route('notifications.delete', $notif->Noto_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="notif-delete-btn" title="Eliminar notificación">✕</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
