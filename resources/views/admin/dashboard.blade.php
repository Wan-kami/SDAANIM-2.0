@extends('layouts.app')

@section('panel-title', 'Panel Administrador')

@section('content')

<!-- SweetAlert2 para mensaje de bienvenida -->
@if(session('welcome'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: 'Bienvenido',
            text: "{{ session('welcome') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#2e8b57'
        });
    </script>
@endif

<div class="premium-dashboard-container">
    <!-- SIDEBAR -->
    <aside class="dashboard-sidebar">
        <div class="sidebar-brand-section">
            <div class="brand-logo-container">
                <img src="{{ asset('img/a.png') }}" alt="Logo" class="brand-logo-img">
            </div>
            <div class="brand-text-container">
                <h1 class="brand-title-text">SDAANIM</h1>
                <p class="brand-subtitle-text">Adopta. Ama. Transforma.</p>
            </div>
        </div>

        <nav class="sidebar-navigation">
            <div class="nav-item-wrapper">
                <a href="{{ route('admin.dashboard') }}" class="nav-link-item active">
                    <span class="nav-item-icon">🏠</span>
                    <span class="nav-item-label">Dashboard</span>
                </a>
            </div>

            <div class="nav-group-section">
                <p class="nav-group-title">GESTIÓN</p>
                <a href="{{ route('admin.animals') }}" class="nav-link-item">
                    <span class="nav-item-icon">🐾</span>
                    <span class="nav-item-label">Animales</span>
                </a>
                <a href="{{ route('admin.adoptions') }}" class="nav-link-item">
                    <span class="nav-item-icon">📥</span>
                    <span class="nav-item-label">Solicitudes de adopción</span>
                </a>
                <div class="sub-nav-group">
                    <p class="sub-nav-title">Usuarios</p>
                    <a href="{{ route('admin.adoptants') }}" class="nav-link-item sub-link">
                        <span class="nav-item-icon">📋</span>
                        <span class="nav-item-label">Adoptantes</span>
                    </a>
                    <a href="{{ route('admin.volunteers') }}" class="nav-link-item sub-link">
                        <span class="nav-item-icon">👥</span>
                        <span class="nav-item-label">Voluntarios</span>
                    </a>
                    <a href="{{ route('admin.veterinarians') }}" class="nav-link-item sub-link">
                        <span class="nav-item-icon">⚕️</span>
                        <span class="nav-item-label">Veterinarios</span>
                    </a>
                </div>
            </div>

            <div class="nav-group-section">
                <p class="nav-group-title">HERRAMIENTAS</p>
                <a href="{{ route('admin.products') }}" class="nav-link-item">
                    <span class="nav-item-icon">🛒</span>
                    <span class="nav-item-label">Productos</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-link-item">
                    <span class="nav-item-icon">📦</span>
                    <span class="nav-item-label">Pedidos</span>
                </a>
                <a href="{{ route('admin.tasks') }}" class="nav-link-item">
                    <span class="nav-item-icon">📝</span>
                    <span class="nav-item-label">Tareas</span>
                </a>
                <a href="{{ route('admin.medical') }}" class="nav-link-item">
                    <span class="nav-item-icon">🏥</span>
                    <span class="nav-item-label">Médico</span>
                </a>
                <a href="{{ route('admin.about') }}" class="nav-link-item">
                    <span class="nav-item-icon">✍️</span>
                    <span class="nav-item-label">Portal Público</span>
                </a>
            </div>
        </nav>

        <!-- Profile / Logout Area -->
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
        <!-- TOP NAVBAR -->
        <header class="main-panel-header">
            <div class="header-welcome-col">
                <h2 class="header-main-title">Dashboard</h2>
                <p class="header-subtitle-text">Resumen general de la plataforma</p>
            </div>
            
            <div class="header-actions-col">
                <!-- Search bar -->
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

                <!-- Public site link -->
                <a href="{{ route('welcome') }}" class="view-website-btn" target="_blank">
                    Ver sitio web ↗
                </a>
            </div>
        </header>

        <!-- STATS CARDS GRID -->
        <section class="stats-cards-grid">
            <!-- Card 1: Successful Adoptions -->
            <div class="stat-card card-green">
                <div class="stat-card-top">
                    <div class="stat-icon-circle bg-green-light">🐾</div>
                    <div class="stat-title-group">
                        <p class="stat-card-label">Adopciones exitosas</p>
                        <h3 class="stat-card-value">{{ number_format($successfulAdoptionsCount) }}</h3>
                    </div>
                </div>
                <!-- Sparkline SVG -->
                <div class="stat-card-graph">
                    <svg viewBox="0 0 100 25" class="sparkline-svg">
                        <path d="M 0,20 Q 15,10 30,17 T 60,8 T 80,12 T 100,5" fill="none" stroke="#22c55e" stroke-width="2.5" stroke-linecap="round"></path>
                    </svg>
                </div>
                <div class="stat-card-trend green-trend">
                    <span class="trend-indicator">▲ +12%</span> vs. mes anterior
                </div>
            </div>

            <!-- Card 2: Pending Requests -->
            <div class="stat-card card-orange">
                <div class="stat-card-top">
                    <div class="stat-icon-circle bg-orange-light">🧡</div>
                    <div class="stat-title-group">
                        <p class="stat-card-label">Solicitudes pendientes</p>
                        <h3 class="stat-card-value">{{ $pendingAdoptionsCount }}</h3>
                    </div>
                </div>
                <!-- Sparkline SVG -->
                <div class="stat-card-graph">
                    <svg viewBox="0 0 100 25" class="sparkline-svg">
                        <path d="M 0,18 Q 20,22 40,15 T 70,20 T 100,10" fill="none" stroke="#f97316" stroke-width="2.5" stroke-linecap="round"></path>
                    </svg>
                </div>
                <div class="stat-card-trend orange-trend">
                    <span class="trend-indicator">▲ +8%</span> vs. mes anterior
                </div>
            </div>

            <!-- Card 3: Registered Users -->
            <div class="stat-card card-teal">
                <div class="stat-card-top">
                    <div class="stat-icon-circle bg-teal-light">👥</div>
                    <div class="stat-title-group">
                        <p class="stat-card-label">Usuarios registrados</p>
                        <h3 class="stat-card-value">{{ number_format($totalUsersCount) }}</h3>
                    </div>
                </div>
                <!-- Sparkline SVG -->
                <div class="stat-card-graph">
                    <svg viewBox="0 0 100 25" class="sparkline-svg">
                        <path d="M 0,22 Q 25,12 50,18 T 80,7 T 100,5" fill="none" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round"></path>
                    </svg>
                </div>
                <div class="stat-card-trend teal-trend">
                    <span class="trend-indicator">▲ +15%</span> vs. mes anterior
                </div>
            </div>

            <!-- Card 4: Housed Animals -->
            <div class="stat-card card-purple">
                <div class="stat-card-top">
                    <div class="stat-icon-circle bg-purple-light">🏠</div>
                    <div class="stat-title-group">
                        <p class="stat-card-label">Mascotas albergadas</p>
                        <h3 class="stat-card-value">{{ $totalAnimalsCount }}</h3>
                    </div>
                </div>
                <!-- Sparkline SVG -->
                <div class="stat-card-graph">
                    <svg viewBox="0 0 100 25" class="sparkline-svg">
                        <path d="M 0,20 Q 20,20 40,12 T 75,18 T 100,15" fill="none" stroke="#7c3aed" stroke-width="2.5" stroke-linecap="round"></path>
                    </svg>
                </div>
                <div class="stat-card-trend purple-trend">
                    <span class="trend-indicator">▲ +5%</span> vs. mes anterior
                </div>
            </div>
        </section>

        <!-- CHARTS AND FEED SECTION -->
        <section class="dashboard-content-layouts">
            <!-- LEFT COLUMN (CHARTS) -->
            <div class="layout-charts-column">
                <!-- Monthly Adoptions line chart -->
                <div class="chart-card-full">
                    <div class="chart-card-header">
                        <h4 class="chart-title">Adopciones por mes</h4>
                        <div class="chart-timeframe-selector">
                            <select class="timeframe-select">
                                <option>Este año</option>
                                <option>Año anterior</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart-canvas-wrapper" style="position: relative; height:240px; width:100%;">
                        <canvas id="monthlyAdoptionsLineChart"></canvas>
                    </div>
                </div>

                <!-- Donut Charts Grid -->
                <div class="donut-charts-row">
                    <!-- Donut 1: Animals by status -->
                    <div class="donut-chart-card">
                        <h4 class="chart-title mb-4">Animales por estado</h4>
                        <div class="donut-chart-flex">
                            <div class="donut-canvas-container">
                                <canvas id="animalsStatusDonutChart"></canvas>
                                <div class="donut-center-label">
                                    <span class="donut-center-total" id="status-total-val">0</span>
                                    <span class="donut-center-sub">Total</span>
                                </div>
                            </div>
                            <div class="donut-legend-list">
                                <div class="legend-item">
                                    <span class="legend-bullet bullet-green"></span>
                                    <span class="legend-label">Disponibles</span>
                                    <span class="legend-value" id="status-disp-val">{{ $animalesPorEstado['disponibles'] }}</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-bullet bullet-orange"></span>
                                    <span class="legend-label">En proceso</span>
                                    <span class="legend-value" id="status-proc-val">{{ $animalesPorEstado['en_proceso'] }}</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-bullet bullet-blue"></span>
                                    <span class="legend-label">Adoptados</span>
                                    <span class="legend-value" id="status-adop-val">{{ $animalesPorEstado['adoptados'] }}</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-bullet bullet-purple"></span>
                                    <span class="legend-label">No disponibles</span>
                                    <span class="legend-value" id="status-nodisp-val">{{ $animalesPorEstado['no_disponibles'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Donut 2: Animals by type -->
                    <div class="donut-chart-card">
                        <h4 class="chart-title mb-4">Adopciones por tipo de animal</h4>
                        <div class="donut-chart-flex">
                            <div class="donut-canvas-container">
                                <canvas id="animalsTypeDonutChart"></canvas>
                                <div class="donut-center-label">
                                    <span class="donut-center-total" id="type-total-val">0</span>
                                    <span class="donut-center-sub">Total</span>
                                </div>
                            </div>
                            <div class="donut-legend-list">
                                <div class="legend-item">
                                    <span class="legend-bullet bullet-green"></span>
                                    <span class="legend-label">Perros</span>
                                    <span class="legend-value" id="type-dog-val">{{ $animalesPorTipo['perros'] }}</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-bullet bullet-orange"></span>
                                    <span class="legend-label">Gatos</span>
                                    <span class="legend-value" id="type-cat-val">{{ $animalesPorTipo['gatos'] }}</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-bullet bullet-purple"></span>
                                    <span class="legend-label">Otros</span>
                                    <span class="legend-value" id="type-other-val">{{ $animalesPorTipo['otros'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Promo Banner -->
                <div class="promo-banner-card">
                    <div class="promo-banner-content">
                        <h3 class="promo-banner-text">Cada número cuenta una historia de amor 🧡</h3>
                        <p class="promo-banner-subtext">Gracias por ser parte del cambio.</p>
                        <a href="{{ route('admin.adoptions') }}" class="promo-banner-btn">Ver reportes completos</a>
                    </div>
                    <div class="promo-banner-graphic">
                        <!-- Custom clean vector/svg illustration for animals shelter -->
                        <svg viewBox="0 0 160 120" class="promo-banner-svg">
                            <rect x="10" y="40" width="140" height="70" rx="10" fill="#e2efe0"></rect>
                            <!-- Dog shape -->
                            <path d="M 40,80 Q 45,70 50,80 T 60,75 T 70,85" stroke="#2e8b57" stroke-width="4" fill="none" stroke-linecap="round"></path>
                            <circle cx="48" cy="74" r="3" fill="#2e8b57"></circle>
                            <path d="M 42,70 Q 40,65 37,72" fill="#2e8b57"></path>
                            <!-- Cat shape -->
                            <path d="M 90,80 Q 95,73 100,80 T 110,77 T 120,83" stroke="#f97316" stroke-width="4" fill="none" stroke-linecap="round"></path>
                            <circle cx="98" cy="74" r="2.5" fill="#f97316"></circle>
                            <path d="M 93,68 L 95,72 L 91,72 Z" fill="#f97316"></path>
                            <path d="M 103,68 L 101,72 L 105,72 Z" fill="#f97316"></path>
                            <!-- Heart shape -->
                            <path d="M 75,55 Q 70,50 75,45 Q 80,50 75,55" fill="#f97316"></path>
                            <path d="M 75,55 Q 80,50 75,45 Q 70,50 75,55" fill="#f97316"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN (FEED & LISTS) -->
            <div class="layout-feed-column">
                <!-- Recent Requests Card -->
                <div class="feed-card">
                    <div class="feed-card-header">
                        <h4 class="feed-card-title">Solicitudes recientes</h4>
                        <a href="{{ route('admin.adoptions') }}" class="feed-card-link">Ver todas</a>
                    </div>
                    <div class="feed-list">
                        @foreach($mappedRequests as $req)
                        <div class="feed-item">
                            <div class="feed-avatar-wrapper">
                                @if($req['foto'])
                                    <img src="{{ $req['foto'] }}" alt="{{ $req['name'] }}" class="feed-avatar-img">
                                @else
                                    <div class="feed-avatar-placeholder">🐾</div>
                                @endif
                            </div>
                            <div class="feed-details">
                                <p class="feed-item-title">{{ $req['name'] }}</p>
                                <p class="feed-item-sub">{{ $req['desc'] }}</p>
                            </div>
                            <div class="feed-meta">
                                <span class="status-badge {{ $req['status_class'] }}">{{ $req['status'] }}</span>
                                <span class="feed-item-time">{{ $req['time'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Activity Timeline -->
                <div class="feed-card">
                    <div class="feed-card-header">
                        <h4 class="feed-card-title">Actividad reciente</h4>
                        <a href="{{ route('admin.tasks') }}" class="feed-card-link">Ver todas</a>
                    </div>
                    <div class="timeline-list">
                        @foreach($activities as $act)
                        <div class="timeline-item">
                            <div class="timeline-icon-circle {{ $act['icon_class'] }}">
                                {{ $act['icon'] }}
                            </div>
                            <div class="timeline-details">
                                <p class="timeline-item-title">{{ $act['title'] }}</p>
                                <p class="timeline-item-desc">{{ $act['desc'] }}</p>
                                <p class="timeline-item-time">{{ $act['time'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<!-- Modal para ver la foto de perfil en grande (integrado) -->
<div id="modalFoto" class="modal-foto" onclick="cerrarModalFoto(event)">
    <span class="cerrar-modal-foto" onclick="cerrarModalFoto(event)">&times;</span>
    <img class="modal-foto-contenido" id="modalFotoImg">
</div>

@endsection

@section('styles')
<!-- Google Fonts (Montserrat importado en app.blade.php) -->

<style>
    /* PAGE RESET & LAYOUT OVERRIDES */
    body.admin-unified-layout {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden !important;
    }
    body.admin-unified-layout .admin-header-professional {
        display: none !important;
    }
    body.admin-unified-layout .main-content-area {
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        min-height: 100vh !important;
    }
    body.admin-unified-layout .container-fluid.content-container,
    body.admin-unified-layout .content-container {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    body.admin-unified-layout .main-footer-professional {
        display: none !important;
    }

    /* PREMIUM CONTAINER */
    .premium-dashboard-container {
        display: grid;
        grid-template-columns: 280px 1fr;
        min-height: 100vh;
        background-color: #f8fafc;
        color: #1e293b;
        font-family: 'Montserrat', sans-serif;
    }

    /* SIDEBAR STYLES */
    .dashboard-sidebar {
        background-color: #ffffff;
        border-right: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        height: 100vh;
        position: sticky;
        top: 0;
        padding: 24px 16px;
        z-index: 50;
    }

    .sidebar-brand-section {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 32px;
        padding: 0 8px;
    }

    .brand-logo-container {
        background: #f0fdf4;
        border-radius: 12px;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
    }

    .brand-logo-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .brand-title-text {
        font-size: 1.4rem;
        font-weight: 800;
        margin: 0;
        color: #1e3a27;
        line-height: 1.1;
    }

    .brand-subtitle-text {
        font-size: 0.72rem;
        color: #ea580c;
        margin: 2px 0 0 0;
        font-weight: 600;
        letter-spacing: 0.05em;
    }

    .sidebar-navigation {
        flex: 1;
        overflow-y: auto;
        padding-right: 4px;
    }

    /* Custom scrollbar for sidebar */
    .sidebar-navigation::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-navigation::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .nav-link-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 12px;
        text-decoration: none;
        color: #64748b;
        font-weight: 600;
        font-size: 0.92rem;
        margin-bottom: 6px;
        transition: all 0.2s ease-in-out;
        position: relative;
    }

    .nav-link-item:hover {
        background-color: #f1f5f9;
        color: #1e293b;
    }

    .nav-link-item.active {
        background-color: #f0fdf4;
        color: #16a34a;
    }

    .nav-link-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 25%;
        height: 50%;
        width: 4px;
        background-color: #16a34a;
        border-radius: 0 4px 4px 0;
    }

    .nav-item-icon {
        font-size: 1.15rem;
    }

    .nav-group-section {
        margin-top: 24px;
    }

    .nav-group-title {
        font-size: 0.7rem;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin: 0 0 8px 12px;
    }

    .sub-nav-group {
        margin-left: 12px;
        border-left: 1px solid #e2e8f0;
        padding-left: 8px;
        margin-top: 6px;
    }

    .sub-nav-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: #94a3b8;
        margin: 4px 0 6px 12px;
    }

    .nav-link-item.sub-link {
        padding: 8px 12px;
        font-size: 0.88rem;
    }

    .sidebar-user-footer {
        border-top: 1px solid #f1f5f9;
        padding-top: 16px;
        margin-top: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .user-footer-info {
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: 190px;
    }

    .user-footer-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid #e2e8f0;
        transition: transform 0.2s;
    }
    .user-footer-avatar:hover {
        transform: scale(1.05);
    }

    .user-footer-details {
        overflow: hidden;
    }

    .user-footer-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .user-footer-email {
        font-size: 0.72rem;
        color: #64748b;
        margin: 0;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .sidebar-logout-btn {
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 1.25rem;
        padding: 6px;
        border-radius: 8px;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar-logout-btn:hover {
        background-color: #fee2e2;
    }

    /* MAIN PANEL AREA STYLES */
    .dashboard-main-panel {
        padding: 32px 40px;
        overflow-y: auto;
        height: 100vh;
    }

    .main-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .header-main-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .header-subtitle-text {
        font-size: 0.95rem;
        color: #64748b;
        margin: 4px 0 0 0;
    }

    .header-actions-col {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-search-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 9999px;
        padding: 8px 16px;
        width: 240px;
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .header-search-bar:focus-within {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.12);
    }

    .search-icon-span {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .search-input-field {
        border: none;
        outline: none;
        background: transparent;
        font-size: 0.88rem;
        width: 100%;
        color: #1e293b;
    }

    .header-bell-wrapper {
        position: relative;
    }

    .header-bell-btn {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .header-bell-btn:hover {
        background-color: #f1f5f9;
    }

    .header-bell-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        background-color: #ef4444;
        color: #ffffff;
        font-size: 0.68rem;
        font-weight: 700;
        border-radius: 9999px;
        min-width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        border: 2px solid #ffffff;
    }

    .view-website-btn {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 9px 18px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .view-website-btn:hover {
        border-color: #16a34a;
        color: #16a34a;
        background-color: #f0fdf4;
    }

    /* STATS CARDS GRID */
    .stats-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
    }

    .stat-card-top {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 12px;
    }

    .stat-icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .bg-green-light { background-color: #f0fdf4; color: #16a34a; }
    .bg-orange-light { background-color: #fff7ed; color: #ea580c; }
    .bg-teal-light { background-color: #f0fdfa; color: #0d9488; }
    .bg-purple-light { background-color: #faf5ff; color: #7c3aed; }

    .stat-card-label {
        font-size: 0.84rem;
        font-weight: 600;
        color: #64748b;
        margin: 0;
    }

    .stat-card-value {
        font-size: 1.65rem;
        font-weight: 800;
        color: #0f172a;
        margin: 2px 0 0 0;
        letter-spacing: -0.01em;
    }

    .stat-card-graph {
        height: 25px;
        margin: 8px 0;
    }

    .sparkline-svg {
        width: 100%;
        height: 100%;
    }

    .stat-card-trend {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 6px;
    }

    .trend-indicator {
        font-weight: 700;
    }
    .green-trend .trend-indicator { color: #22c55e; }
    .orange-trend .trend-indicator { color: #f97316; }
    .teal-trend .trend-indicator { color: #0d9488; }
    .purple-trend .trend-indicator { color: #8b5cf6; }

    /* CONTENT LAYOUTS */
    .dashboard-content-layouts {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: start;
    }

    .layout-charts-column {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .chart-card-full {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .chart-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .timeframe-select {
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #334155;
        outline: none;
    }

    /* Donut charts row */
    .donut-charts-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .donut-chart-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .donut-chart-flex {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .donut-canvas-container {
        position: relative;
        width: 120px;
        height: 120px;
        flex-shrink: 0;
    }

    .donut-center-label {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        z-index: 10;
    }

    .donut-center-total {
        font-size: 1.3rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .donut-center-sub {
        font-size: 0.65rem;
        text-transform: uppercase;
        color: #94a3b8;
        font-weight: 700;
        letter-spacing: 0.05em;
        margin-top: 2px;
    }

    .donut-legend-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex-grow: 1;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
    }

    .legend-bullet {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .bullet-green { background-color: #22c55e; }
    .bullet-orange { background-color: #f97316; }
    .bullet-blue { background-color: #3b82f6; }
    .bullet-purple { background-color: #8b5cf6; }

    .legend-label {
        color: #64748b;
        font-weight: 600;
        flex-grow: 1;
    }

    .legend-value {
        color: #0f172a;
        font-weight: 700;
        text-align: right;
    }

    /* Bottom Promo Banner */
    .promo-banner-card {
        background-color: #f0fdf4;
        border: 1px solid #dcfce7;
        border-radius: 20px;
        padding: 24px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        overflow: hidden;
        position: relative;
    }

    .promo-banner-content {
        z-index: 10;
    }

    .promo-banner-text {
        font-size: 1.2rem;
        font-weight: 800;
        color: #14532d;
        margin: 0;
    }

    .promo-banner-subtext {
        font-size: 0.9rem;
        color: #166534;
        margin: 4px 0 16px 0;
    }

    .promo-banner-btn {
        display: inline-block;
        background-color: #ffffff;
        border: 1px solid #bbf7d0;
        color: #166534;
        font-weight: 700;
        font-size: 0.82rem;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .promo-banner-btn:hover {
        background-color: #15803d;
        color: #ffffff;
        border-color: #15803d;
    }

    .promo-banner-graphic {
        width: 140px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .promo-banner-svg {
        width: 100%;
        height: 100%;
    }

    /* RIGHT COLUMN STYLES (FEEDS) */
    .layout-feed-column {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .feed-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .feed-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .feed-card-title {
        font-size: 1rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .feed-card-link {
        font-size: 0.8rem;
        font-weight: 700;
        color: #16a34a;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .feed-card-link:hover {
        opacity: 0.8;
    }

    .feed-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .feed-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .feed-item:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .feed-avatar-wrapper {
        flex-shrink: 0;
    }

    .feed-avatar-img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
    }

    .feed-avatar-placeholder {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }

    .feed-details {
        flex-grow: 1;
        overflow: hidden;
    }

    .feed-item-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .feed-item-sub {
        font-size: 0.75rem;
        color: #64748b;
        margin: 2px 0 0 0;
    }

    .feed-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 4px;
        flex-shrink: 0;
    }

    .status-badge {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 9999px;
        text-transform: capitalize;
    }
    .status-pending { background-color: #fff7ed; color: #ea580c; }
    .status-review { background-color: #eff6ff; color: #2563eb; }

    .feed-item-time {
        font-size: 0.7rem;
        color: #94a3b8;
    }

    /* TIMELINE STYLES */
    .timeline-list {
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .timeline-item {
        display: flex;
        gap: 16px;
        position: relative;
        padding-bottom: 20px;
    }
    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 17px;
        top: 28px;
        height: calc(100% - 22px);
        width: 2px;
        background-color: #e2e8f0;
        z-index: 1;
    }
    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        z-index: 2;
        flex-shrink: 0;
        box-shadow: 0 0 0 4px #ffffff;
    }

    .activity-icon-check { background-color: #dcfce7; color: #166534; }
    .activity-icon-paw { background-color: #ffedd5; color: #9a3412; }
    .activity-icon-user { background-color: #f3e8ff; color: #581c87; }

    .timeline-details {
        flex-grow: 1;
        padding-top: 2px;
    }

    .timeline-item-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .timeline-item-desc {
        font-size: 0.78rem;
        color: #64748b;
        margin: 2px 0 0 0;
        line-height: 1.4;
    }

    .timeline-item-time {
        font-size: 0.72rem;
        color: #94a3b8;
        margin: 4px 0 0 0;
        font-weight: 500;
    }

    /* RESPONSIVE DESIGN */
    @media (max-width: 1200px) {
        .premium-dashboard-container {
            grid-template-columns: 80px 1fr;
        }
        .dashboard-sidebar {
            padding: 24px 8px;
            align-items: center;
        }
        .brand-text-container,
        .nav-item-label,
        .nav-group-title,
        .sub-nav-group,
        .user-footer-details {
            display: none;
        }
        .brand-logo-container {
            margin-bottom: 0;
        }
        .sidebar-brand-section {
            padding: 0;
            justify-content: center;
        }
        .nav-link-item {
            justify-content: center;
            width: 44px;
            height: 44px;
            padding: 0;
        }
        .sidebar-user-footer {
            justify-content: center;
            border-top: none;
        }
        .user-footer-avatar {
            margin: 0;
        }
    }

    @media (max-width: 992px) {
        .dashboard-content-layouts {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .dashboard-main-panel {
            padding: 20px;
        }
        .main-panel-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        .header-actions-col {
            width: 100%;
            justify-content: space-between;
        }
        .donut-charts-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('scripts')
<!-- Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. LINE CHART: Adopciones por mes ---
        const ctxLine = document.getElementById('monthlyAdoptionsLineChart').getContext('2d');
        
        // Gradient fill for line chart
        const lineGradient = ctxLine.createLinearGradient(0, 0, 0, 240);
        lineGradient.addColorStop(0, 'rgba(46, 139, 87, 0.25)');
        lineGradient.addColorStop(1, 'rgba(46, 139, 87, 0.0)');

        const monthlyData = @json($adopcionesPorMes);

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Adopciones',
                    data: monthlyData,
                    borderColor: '#2e8b57',
                    borderWidth: 3,
                    pointBackgroundColor: '#2e8b57',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.35,
                    fill: true,
                    backgroundColor: lineGradient
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: 'Inter',
                                size: 11,
                                weight: '600'
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: '#f1f5f9'
                        },
                        border: {
                            dash: [5, 5]
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: 'Inter',
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        // --- 2. DONUT CHART: Animales por estado ---
        const ctxStatus = document.getElementById('animalsStatusDonutChart').getContext('2d');
        const dispVal = parseInt(document.getElementById('status-disp-val').innerText) || 0;
        const procVal = parseInt(document.getElementById('status-proc-val').innerText) || 0;
        const adopVal = parseInt(document.getElementById('status-adop-val').innerText) || 0;
        const nodispVal = parseInt(document.getElementById('status-nodisp-val').innerText) || 0;
        const totalStatus = dispVal + procVal + adopVal + nodispVal;
        
        document.getElementById('status-total-val').innerText = totalStatus;

        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Disponibles', 'En proceso', 'Adoptados', 'No disponibles'],
                datasets: [{
                    data: [dispVal, procVal, adopVal, nodispVal],
                    backgroundColor: ['#22c55e', '#f97316', '#3b82f6', '#8b5cf6'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        cornerRadius: 8,
                        padding: 8
                    }
                }
            }
        });

        // --- 3. DONUT CHART: Animales por tipo ---
        const ctxType = document.getElementById('animalsTypeDonutChart').getContext('2d');
        const dogVal = parseInt(document.getElementById('type-dog-val').innerText) || 0;
        const catVal = parseInt(document.getElementById('type-cat-val').innerText) || 0;
        const otherVal = parseInt(document.getElementById('type-other-val').innerText) || 0;
        const totalType = dogVal + catVal + otherVal;
        
        document.getElementById('type-total-val').innerText = totalType;

        new Chart(ctxType, {
            type: 'doughnut',
            data: {
                labels: ['Perros', 'Gatos', 'Otros'],
                datasets: [{
                    data: [dogVal, catVal, otherVal],
                    backgroundColor: ['#22c55e', '#f97316', '#8b5cf6'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        cornerRadius: 8,
                        padding: 8
                    }
                }
            }
        });
    });
</script>
@endsection
