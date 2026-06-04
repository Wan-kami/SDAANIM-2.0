@extends('layouts.vet.app')

@section('title', 'Panel Veterinario')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/vet/dashboard.css') }}">
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
            color: #1C9F96;
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
            border-left: 4px solid #1C9F96;
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

        .stat-card.urgent {
            border-left-color: #f44336;
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
            color: #1C9F96;
        }

        .stat-card.pending .stat-value {
            color: #ff9800;
        }

        .stat-card.completed .stat-value {
            color: #4caf50;
        }

        .stat-card.urgent .stat-value {
            color: #f44336;
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
            background: linear-gradient(90deg, #1C9F96, #0d7a6b);
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

        .task-item, .animal-item, .activity-item {
            background: white;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border-left: 4px solid #1C9F96;
            transition: all 0.2s ease;
        }

        .task-item:hover, .animal-item:hover, .activity-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .task-item.completed {
            border-left-color: #4caf50;
            opacity: 0.7;
        }

        .task-item.pending {
            border-left-color: #ff9800;
        }

        .task-item.urgent {
            border-left-color: #f44336;
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }

        .item-title {
            font-weight: 600;
            color: #333;
            margin: 0;
            flex: 1;
        }

        .item-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .item-status.pending {
            background: #fff3e0;
            color: #f57c00;
        }

        .item-status.completed {
            background: #e8f5e9;
            color: #388e3c;
        }

        .item-status.urgent {
            background: #ffebee;
            color: #c62828;
        }

        .item-description {
            color: #666;
            font-size: 0.9rem;
            margin: 8px 0 0 0;
            line-height: 1.4;
        }

        .item-date {
            color: #999;
            font-size: 0.8rem;
            margin-top: 8px;
        }

        .animal-item {
            border-left-color: #4caf50;
        }

        .animal-badge {
            display: inline-block;
            background: #e8f5e9;
            color: #388e3c;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
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
            background: #1C9F96;
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
            background: #0d7a6b;
        }

        .three-column {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        @media (max-width: 1024px) {
            .three-column {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
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
        <h1>Bienvenido, Dr. {{ Auth::user()->name }} 🐾</h1>
        <p>Gestiona la salud y bienestar de nuestros rescatados. Aquí está tu resumen de actividades clínicas.</p>
    </div>

    <!-- THREE COLUMN LAYOUT -->
    <div class="three-column">
        <!-- PENDING TASKS -->
        <div class="recent-section">
            <div class="section-title">
                <span>📝</span> Tareas Urgentes
            </div>

            @if($recentTasks && count($recentTasks) > 0)
                @foreach($recentTasks as $task)
                <div class="task-item {{ strtolower($task->Tar_estado) }}">
                    <div class="item-header">
                        <p class="item-title">{{ $task->Tar_titulo }}</p>
                        <span class="item-status {{ strtolower($task->Tar_estado) }}">
                            {{ $task->Tar_estado }}
                        </span>
                    </div>
                    <p class="item-description">{{ Str::limit($task->Tar_descripcion, 80) }}</p>
                    @if($task->Tar_fecha_limite)
                        <div class="item-date">
                            ⏰ {{ \Carbon\Carbon::parse($task->Tar_fecha_limite)->format('d/m/Y H:i') }}
                        </div>
                    @endif
                </div>
                @endforeach
                <a href="{{ route('vet.tasks') }}" class="action-button" style="width: 100%; text-align: center; margin-top: 15px;">Ver todas las tareas</a>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">✨</div>
                    <p>No tienes tareas urgentes.</p>
                    <a href="{{ route('vet.tasks') }}" class="action-button">Ir a tareas</a>
                </div>
            @endif
        </div>

        <!-- ANIMALS UNDER CARE -->
        <div class="recent-section">
            <div class="section-title">
                <span>🐾</span> Animales Bajo Cuidado
            </div>

            @if($animalsUnderCare && count($animalsUnderCare) > 0)
                @foreach($animalsUnderCare as $animal)
                <div class="animal-item">
                    <p class="item-title">{{ $animal->Anim_nombre }}</p>
                    <p class="item-description">
                        <strong>Raza:</strong> {{ $animal->Anim_raza }} | <strong>Edad:</strong> {{ $animal->Anim_edad }}
                    </p>
                    <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                        <span class="animal-badge">{{ $animal->Anim_estado }}</span>
                        <a href="{{ route('animal.medical-history', $animal->Anim_id) }}" class="action-button" style="margin: 0;">Ver historial</a>
                    </div>
                </div>
                @endforeach
                <a href="{{ route('vet.animals') }}" class="action-button" style="width: 100%; text-align: center; margin-top: 15px;">Ver todos los animales</a>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>No tienes animales bajo tu cuidado aún.</p>
                    <a href="{{ route('vet.animals') }}" class="action-button">Ir a historiales</a>
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
            <div class="icon">📋</div>
            <h3>Historiales Médicos</h3>
            <p>Accede a la base de datos completa de registros de salud.</p>
            <a href="{{ route('vet.animals') }}">Gestionar Historiales</a>
        </div>
        <div class="admin-card">
            <div class="icon">📝</div>
            <h3>Mis Tareas</h3>
            <p>Revisa las tareas asignadas y regístralas como completadas.</p>
            <a href="{{ route('vet.tasks') }}">Ver Tareas</a>
        </div>
        <div class="admin-card" style="border-top: 5px solid #ffa500;">
            <div class="icon">📈</div>
            <h3>Mi Progreso</h3>
            <p>Consulta el historial y avance visual de tus labores clínicas.</p>
            <a href="{{ route('vet.progress') }}" style="background: #ffa500; box-shadow: 0 4px 10px rgba(255, 165, 0, 0.3);">Ver Mi Progreso</a>
        </div>
    </section>
</div>
@endsection
