@extends('layouts.app')

@section('panel-title', 'Mi Progreso')

@section('styles')
<style>
    .progress-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }
    .progress-page-header h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        margin: 0 0 8px 0;
    }
    .progress-page-header p {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
    }
    .progress-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }
    .progress-summary-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px 24px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }
    .progress-summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }
    .progress-summary-card h3 {
        margin: 12px 0 4px;
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
    }
    .progress-summary-card p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 600;
    }
    .progress-section-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        border-left: 5px solid #16a34a;
        padding-left: 16px;
        margin-bottom: 24px;
    }
    .progress-task-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }
    .progress-task-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    .progress-task-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }
    .progress-task-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .progress-task-date {
        color: #64748b;
        font-size: 0.85rem;
        margin: 4px 0 0 0;
    }
    .progress-badge {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 99px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .progress-bar-container {
        width: 100%;
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }
    .progress-bar-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 700;
        margin-top: 6px;
    }
    .progress-report-box {
        margin-top: 16px;
        padding: 14px 18px;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 3px solid #16a34a;
    }
    .progress-report-box p {
        margin: 0;
        font-size: 0.9rem;
        color: #475569;
    }
    .progress-task-card {
        position: relative;
    }
    .progress-delete-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: #fef2f2;
        color: #ef4444;
        font-size: 1rem;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        z-index: 5;
    }
    .progress-task-card.completado:hover .progress-delete-btn {
        display: flex;
    }
    .progress-delete-btn:hover {
        background: #ef4444;
        color: white;
        transform: scale(1.1);
    }
    .progress-empty {
        text-align: center;
        padding: 60px 20px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    .progress-empty p {
        color: #94a3b8;
        font-size: 1rem;
    }
    .progress-task-list {
        flex: 1;
        overflow-y: auto;
    }
    .btn-primary-link {
        display: inline-block;
        background: #16a34a;
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);
    }
    .btn-primary-link:hover {
        background: #15803d;
        transform: translateY(-1px);
    }
    @media (max-width: 768px) {
        .progress-page-container { padding: 20px 16px; }
        .progress-page-header { flex-direction: column; gap: 16px; align-items: flex-start; }
        .progress-task-card { padding: 20px; }
    }
</style>
@endsection

@section('content')
<div class="premium-dashboard-container">
    @include(Auth::user()->role == 'Veterinario' ? 'partials.vet_sidebar' : 'partials.volunteer_sidebar')

    <main class="dashboard-main-panel">
        <div class="progress-page-container">
            <div class="progress-page-header">
                <div>
                    <h1>Mi Progreso 🏆</h1>
                    <p>Visualiza el avance de tus labores en el refugio.</p>
                </div>
                <a href="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.tasks' : 'volunteer.tasks') }}" class="btn-primary-link">📋 Ir a Mis Tareas Pendientes</a>
            </div>

            @if(session('success'))
                <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">{{ session('error') }}</div>
            @endif

            <div class="progress-summary-grid">
                <div class="progress-summary-card" style="border-bottom: 4px solid #0ea5e9;">
                    <span style="font-size: 2em;">📅</span>
                    <h3>{{ $totalCount }}</h3>
                    <p>Tareas Totales</p>
                </div>
                <div class="progress-summary-card" style="border-bottom: 4px solid #f59e0b;">
                    <span style="font-size: 2em;">⏳</span>
                    <h3>{{ $pendingCount }}</h3>
                    <p>En Curso</p>
                </div>
                <div class="progress-summary-card" style="border-bottom: 4px solid #10b981;">
                    <span style="font-size: 2em;">✅</span>
                    <h3>{{ $completedCount }}</h3>
                    <p>Completadas</p>
                </div>
            </div>

            <h2 class="progress-section-title">Seguimiento de Actividades</h2>

            <div>
                @forelse($allTasks as $task)
                    @php
                        $colors = $task->status_colors;
                        $percent = $colors['progress'];
                        $color = $colors['border'];
                    @endphp
                    <div class="progress-task-card {{ strtolower($task->Tar_estado) }}">
                        @if($task->Tar_estado === 'Completado')
                        <form action="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.tasks.removeProgress' : 'volunteer.tasks.removeProgress', $task->Tar_id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta tarea completada del historial?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="progress-delete-btn" title="Quitar de la pantalla">✕</button>
                        </form>
                        @endif
                        <div class="progress-task-top">
                            <div>
                                <h3 class="progress-task-title">{{ $task->Tar_titulo }}</h3>
                                <p class="progress-task-date">Asignada el: {{ $task->Tar_fecha_asignacion->format('d/m/Y') }}</p>
                            </div>
                            <span class="progress-badge" style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }};">
                                {{ $task->Tar_estado }}
                            </span>
                        </div>

                        <div class="progress-bar-container">
                            <div class="progress-bar-fill" style="width: {{ $percent }}%; background: {{ $color }};"></div>
                        </div>
                        <div class="progress-bar-labels">
                            <span>INICIO</span>
                            <span>{{ $percent }}%</span>
                            <span>FINAL</span>
                        </div>

                        @if($task->Tar_comentario)
                            <div class="progress-report-box" style="border-left-color: {{ $color }};">
                                <p><strong>Mi Reporte:</strong> "{{ $task->Tar_comentario }}"</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="progress-empty">
                        <p>Aún no tienes actividades registradas para mostrar progreso 🐾</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection
