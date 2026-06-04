@extends('layouts.volunteer.app')

@section('title', 'Panel Voluntario | SDAANIM')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/volunteer/dashboard.css') }}">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeIn 0.5s ease;
        }

        .welcome-section h1 {
            color: #007acc;
            font-family: 'Pacifico', cursive;
            font-size: 2.2rem;
            margin-bottom: 5px;
        }

        .welcome-section p {
            color: #666;
            font-size: 1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-left: 4px solid #007acc;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }

        .stat-card.pending {
            border-left-color: #ff9800;
        }

        .stat-card.completed {
            border-left-color: #4caf50;
        }

        .stat-card.progress {
            border-left-color: #9c27b0;
        }

        .stat-icon {
            font-size: 2.5rem;
        }

        .stat-content h3 {
            margin: 0 0 5px 0;
            color: #666;
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #007acc;
        }

        .stat-card.pending .stat-value {
            color: #ff9800;
        }

        .stat-card.completed .stat-value {
            color: #4caf50;
        }

        .stat-card.progress .stat-value {
            color: #9c27b0;
        }

        .progress-bar-container {
            width: 100%;
            height: 6px;
            background: #e0e0e0;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 8px;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #007acc, #0056b3);
            width: 0%;
            transition: width 0.5s ease;
            border-radius: 3px;
        }

        .section-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .recent-section {
            margin-bottom: 50px;
        }

        .task-item, .activity-item {
            background: white;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border-left: 4px solid #007acc;
            transition: all 0.2s ease;
        }

        .task-item:hover, .activity-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .task-item.completed {
            border-left-color: #4caf50;
            opacity: 0.7;
        }

        .task-item.pending {
            border-left-color: #ff9800;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }

        .task-title {
            font-weight: 600;
            color: #333;
            margin: 0;
            flex: 1;
        }

        .task-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .task-status.pending {
            background: #fff3e0;
            color: #f57c00;
        }

        .task-status.completed {
            background: #e8f5e9;
            color: #388e3c;
        }

        .task-description {
            color: #666;
            font-size: 0.9rem;
            margin: 8px 0 0 0;
            line-height: 1.4;
        }

        .task-date {
            color: #999;
            font-size: 0.8rem;
            margin-top: 8px;
        }

        .activity-item {
            border-left-color: #2196f3;
        }

        .activity-message {
            color: #333;
            font-size: 0.95rem;
            margin: 0;
        }

        .activity-time {
            color: #999;
            font-size: 0.8rem;
            margin-top: 8px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .action-button {
            display: inline-block;
            margin-top: 5px;
            padding: 8px 15px;
            background: #007acc;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .action-button:hover {
            background: #0056b3;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .two-column {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .welcome-section h1 {
                font-size: 1.5rem;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

@section('content')
<div class="dashboard-container">
    <div class="welcome-section">
        <h1>Bienvenido, {{ Auth::user()->name }} 🐾</h1>
        <p>Tu labor como voluntario es fundamental para nosotros. Aquí está tu resumen de actividades.</p>
    </div>

    <!-- STATS GRID -->
    <div class="stats-grid">
        <div class="stat-card pending">
            <div class="stat-icon">📋</div>
            <div class="stat-content">
                <h3>Tareas Pendientes</h3>
                <div class="stat-value">{{ $stats['tasks_pending'] ?? 0 }}</div>
                <a href="{{ route('volunteer.tasks') }}" class="action-button" style="margin-top: 10px;">Ver tareas</a>
            </div>
        </div>

        <div class="stat-card completed">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <h3>Tareas Completadas</h3>
                <div class="stat-value">{{ $stats['tasks_completed'] ?? 0 }}</div>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: {{ $stats['completion_percentage'] ?? 0 }}%"></div>
                </div>
                <small style="color: #999;">{{ $stats['completion_percentage'] ?? 0 }}% completado</small>
            </div>
        </div>

        <div class="stat-card progress">
            <div class="stat-icon">🔔</div>
            <div class="stat-content">
                <h3>Notificaciones</h3>
                <div class="stat-value">{{ $stats['notifications_unread'] ?? 0 }}</div>
                <a href="{{ route('notifications') }}" class="action-button" style="margin-top: 10px;">Ver todas</a>
            </div>
        </div>
    </div>

    <!-- TWO COLUMN LAYOUT -->
    <div class="two-column">
        <!-- RECENT TASKS -->
        <div class="recent-section">
            <div class="section-title">
                <span>📝</span> Tareas Recientes
            </div>

            @if($recentTasks && count($recentTasks) > 0)
                @foreach($recentTasks as $task)
                <div class="task-item {{ strtolower($task->Tar_estado) }}">
                    <div class="task-header">
                        <p class="task-title">{{ $task->Tar_titulo }}</p>
                        <span class="task-status {{ strtolower($task->Tar_estado) }}">
                            {{ $task->Tar_estado }}
                        </span>
                    </div>
                    <p class="task-description">{{ Str::limit($task->Tar_descripcion, 100) }}</p>
                    @if($task->Tar_fecha_limite)
                        <div class="task-date">
                            ⏰ {{ \Carbon\Carbon::parse($task->Tar_fecha_limite)->format('d/m/Y H:i') }}
                        </div>
                    @endif
                </div>
                @endforeach
                <a href="{{ route('volunteer.tasks') }}" class="action-button" style="width: 100%; text-align: center; margin-top: 15px;">Ver todas mis tareas</a>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>No tienes tareas pendientes por ahora.</p>
                    <a href="{{ route('volunteer.tasks') }}" class="action-button">Ir a mis tareas</a>
                </div>
            @endif
        </div>

        <!-- RECENT ACTIVITY -->
        <div class="recent-section">
            <div class="section-title">
                <span>⚡</span> Actividad Reciente
            </div>

            @if($recentNotifications && count($recentNotifications) > 0)
                @foreach($recentNotifications as $notification)
                <div class="activity-item">
                    <p class="activity-message">{{ $notification->Noti_mensaje }}</p>
                    <div class="activity-time">
                        🕐 {{ \Carbon\Carbon::parse($notification->Noti_fecha)->diffForHumans() }}
                    </div>
                </div>
                @endforeach
                <a href="{{ route('notifications') }}" class="action-button" style="width: 100%; text-align: center; margin-top: 15px;">Ver todas las notificaciones</a>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>No hay actividad reciente.</p>
                    <a href="{{ route('notifications') }}" class="action-button">Ver notificaciones</a>
                </div>
            @endif
        </div>
    </div>

    <!-- QUICK ACCESS SECTION -->
    <section class="admin-sections" style="margin-top: 50px;">
        <div class="admin-card">
            <div class="icon">📈</div>
            <h3>Mi Progreso</h3>
            <p>Consulta el historial y avance visual de tus labores.</p>
            <a href="{{ route('volunteer.progress') }}">Ver Mi Progreso</a>
        </div>
        <div class="admin-card">
            <div class="icon">🏠</div>
            <h3>Mis Tareas</h3>
            <p>Gestiona todas tus tareas asignadas en detalle.</p>
            <a href="{{ route('volunteer.tasks') }}">Ir a Tareas</a>
        </div>
        <div class="admin-card">
            <div class="icon">🔔</div>
            <h3>Notificaciones</h3>
            <p>Mantente informado sobre todas tus actividades.</p>
            <a href="{{ route('notifications') }}">Ver Notificaciones</a>
        </div>
    </section>
</div>
@endsection
