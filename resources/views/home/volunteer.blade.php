@extends('layouts.app')

@section('panel-title', 'Panel Voluntario')

@section('content')
<div class="premium-dashboard-container">
    <!-- SIDEBAR -->
    <aside class="dashboard-sidebar">
        <!-- Logo -->
        <div class="sidebar-brand-section">
            <div class="brand-logo-container">
                <img src="{{ asset('img/a.png') }}" alt="Logo" class="brand-logo-img">
            </div>
            <div class="brand-text-container">
                <h1 class="brand-title-text">SDAANIM</h1>
                <p class="brand-subtitle-text">Adopta. Ama. Transforma.</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-navigation">
            <div class="nav-item-wrapper">
                <a href="{{ route('volunteer.dashboard') }}" class="nav-link-item active">
                    <span class="nav-item-icon">🏠</span>
                    <span class="nav-item-label">Dashboard</span>
                </a>
            </div>

            <div class="nav-group-section">
                <p class="nav-group-title">MÓDULOS VOLUNTARIADO</p>
                <a href="{{ route('volunteer.tasks') }}" class="nav-link-item">
                    <span class="nav-item-icon">📝</span>
                    <span class="nav-item-label">Mis Tareas</span>
                </a>
                <a href="{{ route('volunteer.progress') }}" class="nav-link-item">
                    <span class="nav-item-icon">📈</span>
                    <span class="nav-item-label">Mi Progreso</span>
                </a>
            </div>
        </nav>

        <!-- User Profile Area -->
        <div class="sidebar-user-footer">
            <div class="user-footer-info">
                <img src="{{ Auth::user()->Usu_foto ? asset('img/profiles/' . Auth::user()->Usu_foto) . '?v=' . time() : asset('img/default-avatar.png') }}" class="user-footer-avatar" alt="Profile" onclick="abrirModalFoto(this)">
                <a href="{{ route('profile.edit') }}" class="user-footer-details" style="text-decoration: none; color: inherit;">
                    <p class="user-footer-name">{{ Auth::user()->name }}</p>
                    <p class="user-footer-email">{{ Auth::user()->email }}</p>
                </a>
            </div>
            <form id="logoutForm-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <button type="button" class="sidebar-logout-btn" title="Cerrar sesión" onclick="confirmarLogout(event, 'logoutForm-sidebar')">
                🚪
            </button>
        </div>
    </aside>

    <!-- MAIN PANEL AREA -->
    <main class="dashboard-main-panel">
        <header class="main-panel-header">
            <div class="header-welcome-col">
                <h2 class="header-main-title">Bienvenido, {{ Auth::user()->name }} 🐾</h2>
                <p class="header-subtitle-text">Tu labor como voluntario es fundamental para nosotros.</p>
            </div>
            
            <div class="header-actions-col">
                <div class="header-search-bar">
                    <span class="search-icon-span">🔍</span>
                    <input type="text" placeholder="Buscar..." class="search-input-field">
                </div>
                <!-- Notifications icon -->
                @php
                    $notifCount = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)
                        ->whereNull('read_at')
                        ->count();
                @endphp
                <div class="header-bell-wrapper">
                    <button type="button" class="header-bell-btn" onclick="toggleSidebar()" title="Ver notificaciones">
                        🔔
                        @if($notifCount > 0)
                            <span class="header-bell-badge">{{ $notifCount }}</span>
                        @endif
                    </button>
                </div>
                <a href="{{ route('welcome') }}" class="view-website-btn" target="_blank">
                    Ver sitio web ↗
                </a>
            </div>
        </header>

        <!-- STATS CARDS GRID -->
        <section class="stats-cards-grid">
            <div class="stat-card card-orange">
                <div class="stat-card-top">
                    <div class="stat-icon-circle bg-orange-light">📋</div>
                    <div class="stat-title-group">
                        <p class="stat-card-label">Tareas pendientes</p>
                        <h3 class="stat-card-value">{{ $stats['tasks_pending'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="stat-card card-green">
                <div class="stat-card-top">
                    <div class="stat-icon-circle bg-green-light">✅</div>
                    <div class="stat-title-group">
                        <p class="stat-card-label">Tareas completadas</p>
                        <h3 class="stat-card-value">{{ $stats['tasks_completed'] ?? 0 }}</h3>
                    </div>
                </div>
                <!-- Progress bar -->
                <div style="margin-top: 15px;">
                    <div style="height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                        <div style="height: 100%; background: #22c55e; width: {{ $stats['completion_percentage'] ?? 0 }}%;"></div>
                    </div>
                    <small style="color: #64748b; font-size: 0.75rem; margin-top: 5px; display: block;">{{ $stats['completion_percentage'] ?? 0 }}% de avance general</small>
                </div>
            </div>

            <div class="stat-card card-purple">
                <div class="stat-card-top">
                    <div class="stat-icon-circle bg-purple-light">🔔</div>
                    <div class="stat-title-group">
                        <p class="stat-card-label">Notificaciones</p>
                        <h3 class="stat-card-value">{{ $stats['notifications_unread'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTENT LISTS -->
        <section class="dashboard-content-layouts" style="grid-template-columns: 1fr 1fr; margin-top: 30px; gap: 24px;">
            <!-- PENDING TASKS -->
            <div class="layout-feed-column">
                <div class="feed-card">
                    <div class="feed-card-header">
                        <h4 class="feed-card-title">📝 Tareas Recientes</h4>
                        <a href="{{ route('volunteer.tasks') }}" class="feed-card-link">Ver todas</a>
                    </div>
                    <div class="feed-list">
                        @if($recentTasks && count($recentTasks) > 0)
                            @foreach($recentTasks as $task)
                            <div class="feed-item" style="border-left: 3px solid #f97316;">
                                <div class="feed-details">
                                    <p class="feed-item-title">{{ $task->Tar_titulo }}</p>
                                    <p class="feed-item-sub">{{ Str::limit($task->Tar_descripcion, 80) }}</p>
                                </div>
                                <div class="feed-meta">
                                    <span class="status-badge bg-orange-light" style="color: #c2410c;">{{ $task->Tar_estado }}</span>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p style="text-align: center; color: #94a3b8; padding: 20px 0;">No tienes tareas recientes.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- RECENT ACTIVITY -->
            <div class="layout-feed-column">
                <div class="feed-card">
                    <div class="feed-card-header">
                        <h4 class="feed-card-title">⚡ Actividad Reciente</h4>
                        <a href="{{ route('notifications') }}" class="feed-card-link">Ver todas</a>
                    </div>
                    <div class="timeline-list">
                        @if($recentNotifications && count($recentNotifications) > 0)
                            @foreach($recentNotifications as $notification)
                            <div class="timeline-item">
                                <div class="timeline-icon-circle bg-blue-light" style="color: #1d4ed8;">🔔</div>
                                <div class="timeline-details">
                                    <p class="timeline-item-title">{{ $notification->Noti_mensaje }}</p>
                                    <p class="timeline-item-time">🕐 {{ \Carbon\Carbon::parse($notification->Noti_fecha)->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p style="text-align: center; color: #94a3b8; padding: 20px 0;">No hay actividad reciente.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<!-- Modal para foto -->
<div id="modalFoto" class="modal-foto" onclick="cerrarModalFoto(event)">
    <span class="cerrar-modal-foto" onclick="cerrarModalFoto(event)">&times;</span>
    <img class="modal-foto-contenido" id="modalFotoImg">
</div>
@endsection
