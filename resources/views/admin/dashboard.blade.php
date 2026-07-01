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

<div class="dashboard-unified-container">
    <div class="admin-dashboard-layout">
        <aside class="admin-dashboard-sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('img/a.png') }}" alt="Logo" class="sidebar-logo">
                <div>
                    <h4>Huellas</h4>
                    <p>Admin Panel</p>
                </div>
            </div>

            <div class="sidebar-section">
                <p class="sidebar-section-title">Navegación</p>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
                    <span class="link-icon">🏠</span>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="sidebar-section">
                <p class="sidebar-section-title">Gestión</p>
                <a href="{{ route('admin.animals') }}" class="sidebar-link">
                    <span class="link-icon">🐶</span>
                    <span>Animales</span>
                </a>
                <a href="{{ route('admin.products') }}" class="sidebar-link">
                    <span class="link-icon">🛒</span>
                    <span>Productos</span>
                </a>
                <a href="{{ route('admin.adoptions') }}" class="sidebar-link">
                    <span class="link-icon">📥</span>
                    <span>Solicitudes</span>
                </a>
                <a href="{{ route('admin.veterinarians') }}" class="sidebar-link">
                    <span class="link-icon">⚕️</span>
                    <span>Veterinarios</span>
                </a>
                <a href="{{ route('admin.volunteers') }}" class="sidebar-link">
                    <span class="link-icon">👥</span>
                    <span>Voluntarios</span>
                </a>
                <a href="{{ route('admin.adoptants') }}" class="sidebar-link">
                    <span class="link-icon">📋</span>
                    <span>Adoptantes</span>
                </a>
            </div>

            <div class="sidebar-section">
                <p class="sidebar-section-title">Herramientas</p>
                <a href="{{ route('admin.orders') }}" class="sidebar-link">
                    <span class="link-icon">📦</span>
                    <span>Pedidos</span>
                </a>
                <a href="{{ route('admin.tasks') }}" class="sidebar-link">
                    <span class="link-icon">📝</span>
                    <span>Tareas</span>
                </a>
                <a href="{{ route('admin.medical') }}" class="sidebar-link">
                    <span class="link-icon">🏥</span>
                    <span>Médico</span>
                </a>
                <a href="{{ route('admin.about') }}" class="sidebar-link">
                    <span class="link-icon">📝</span>
                    <span>Portal</span>
                </a>
            </div>
        </aside>

        <main class="admin-dashboard-main">
            <div class="section-header-premium">
                <h3 class="section-title">Gestión de SDAANIM</h3>
                <p class="section-subtitle">Panel principal para la administración de refugios, voluntarios y servicios médicos.</p>
            </div>

            <div class="admin-page-panels" id="page-content">
                <section class="page-panel" id="panel-dashboard">
                    <div class="dashboard-hero-card">
                        <div class="hero-top-row">
                            <div>
                                <span class="hero-label">Dashboard</span>
                                <h2 class="hero-title">Visión general del sistema</h2>
                                <p class="hero-description">Accede rápidamente a los datos clave de la plataforma y navega a cada sección desde el menú izquierdo.</p>
                            </div>
                            <div class="hero-stat">
                                <span>Total registros</span>
                                <strong>{{ array_sum([$stats['animals'] ?? 0, $stats['products'] ?? 0, $stats['adoptants'] ?? 0, $stats['orders'] ?? 0]) }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-summary-grid">
                        <div class="summary-card">
                            <div class="summary-card-icon">🐶</div>
                            <h4>Animales</h4>
                            <p>{{ $stats['animals'] ?? 0 }} animales activos</p>
                        </div>
                        <div class="summary-card">
                            <div class="summary-card-icon">🛒</div>
                            <h4>Productos</h4>
                            <p>{{ $stats['products'] ?? 0 }} elementos en inventario</p>
                        </div>
                        <div class="summary-card">
                            <div class="summary-card-icon">📥</div>
                            <h4>Solicitudes</h4>
                            <p>{{ $stats['adoptions'] ?? 0 }} pendientes</p>
                        </div>
                        <div class="summary-card">
                            <div class="summary-card-icon">👥</div>
                            <h4>Voluntarios</h4>
                            <p>{{ $stats['volunteers'] ?? 0 }} registrados</p>
                        </div>
                        <div class="summary-card">
                            <div class="summary-card-icon">📋</div>
                            <h4>Adoptantes</h4>
                            <p>{{ $stats['adoptants'] ?? 0 }} usuarios</p>
                        </div>
                        <div class="summary-card">
                            <div class="summary-card-icon">📦</div>
                            <h4>Pedidos</h4>
                            <p>{{ $stats['orders'] ?? 0 }} en proceso</p>
                        </div>
                    </div>
                </section>

                <section class="page-panel hidden" id="panel-animales">
                    <div class="panel-header">
                        <h3>Animales</h3>
                        <p>Gestiona animales en adopción y agrega nuevas fotos o perfiles.</p>
                    </div>
                    <div class="panel-card">
                        <div class="panel-card-icon">🐶</div>
                        <div>
                            <p class="panel-value">{{ $stats['animals'] ?? 0 }}</p>
                            <p class="panel-label">Animales registrados</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.animals') }}" class="panel-action">Ir a Animales</a>
                </section>

                <section class="page-panel hidden" id="panel-productos">
                    <div class="panel-header">
                        <h3>Productos</h3>
                        <p>Gestiona los productos disponibles y su información.</p>
                    </div>
                    <div class="panel-card">
                        <div class="panel-card-icon">🛒</div>
                        <div>
                            <p class="panel-value">{{ $stats['products'] ?? 0 }}</p>
                            <p class="panel-label">Productos</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.products') }}" class="panel-action">Ir a Productos</a>
                </section>

                <section class="page-panel hidden" id="panel-solicitudes">
                    <div class="panel-header">
                        <h3>Solicitudes</h3>
                        <p>Revisar y gestionar las solicitudes pendientes de adopción.</p>
                    </div>
                    <div class="panel-card">
                        <div class="panel-card-icon">📥</div>
                        <div>
                            <p class="panel-value">{{ $stats['adoptions'] ?? 0 }}</p>
                            <p class="panel-label">Solicitudes pendientes</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.adoptions') }}" class="panel-action">Ir a Solicitudes</a>
                </section>

                <section class="page-panel hidden" id="panel-veterinarios">
                    <div class="panel-header">
                        <h3>Veterinarios</h3>
                        <p>Agenda citas, revisa solicitudes y coordina atenciones médicas.</p>
                    </div>
                    <div class="panel-card">
                        <div class="panel-card-icon">⚕️</div>
                        <div>
                            <p class="panel-value">{{ $stats['veterinarians'] ?? 0 }}</p>
                            <p class="panel-label">Especialistas</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.veterinarians') }}" class="panel-action">Ir a Veterinarios</a>
                </section>

                <section class="page-panel hidden" id="panel-voluntarios">
                    <div class="panel-header">
                        <h3>Voluntarios</h3>
                        <p>Gestiona las inscripciones de voluntarios y equipos.</p>
                    </div>
                    <div class="panel-card">
                        <div class="panel-card-icon">👥</div>
                        <div>
                            <p class="panel-value">{{ $stats['volunteers'] ?? 0 }}</p>
                            <p class="panel-label">Voluntarios activos</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.volunteers') }}" class="panel-action">Ir a Voluntarios</a>
                </section>

                <section class="page-panel hidden" id="panel-adoptantes">
                    <div class="panel-header">
                        <h3>Adoptantes</h3>
                        <p>Ver y gestionar los adoptantes registrados en el sistema.</p>
                    </div>
                    <div class="panel-card">
                        <div class="panel-card-icon">📋</div>
                        <div>
                            <p class="panel-value">{{ $stats['adoptants'] ?? 0 }}</p>
                            <p class="panel-label">Adoptantes registrados</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.adoptants') }}" class="panel-action">Ir a Adoptantes</a>
                </section>

                <section class="page-panel hidden" id="panel-pedidos">
                    <div class="panel-header">
                        <h3>Pedidos</h3>
                        <p>Revisa los pedidos realizados por los usuarios y su estado.</p>
                    </div>
                    <div class="panel-card">
                        <div class="panel-card-icon">📦</div>
                        <div>
                            <p class="panel-value">{{ $stats['orders'] ?? 0 }}</p>
                            <p class="panel-label">Pedidos actuales</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.orders') }}" class="panel-action">Ir a Pedidos</a>
                </section>

                <section class="page-panel hidden" id="panel-tareas">
                    <div class="panel-header">
                        <h3>Tareas</h3>
                        <p>Gestiona las tareas asignadas y el flujo del sistema.</p>
                    </div>
                    <div class="panel-card">
                        <div class="panel-card-icon">📝</div>
                        <div>
                            <p class="panel-value">{{ $stats['tasks'] ?? 0 }}</p>
                            <p class="panel-label">Tareas pendientes</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.tasks') }}" class="panel-action">Ir a Tareas</a>
                </section>

                <section class="page-panel hidden" id="panel-medico">
                    <div class="panel-header">
                        <h3>Médico</h3>
                        <p>Ver el historial médico detallado de todos los animales.</p>
                    </div>
                    <div class="panel-card">
                        <div class="panel-card-icon">🏥</div>
                        <div>
                            <p class="panel-value">Activo</p>
                            <p class="panel-label">Historial médico</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.medical') }}" class="panel-action">Ir a Historial</a>
                </section>

                <section class="page-panel hidden" id="panel-portal">
                    <div class="panel-header">
                        <h3>Portal</h3>
                        <p>Editar misión, visión y valores públicos del refugio.</p>
                    </div>
                    <div class="panel-card">
                        <div class="panel-card-icon">📝</div>
                        <div>
                            <p class="panel-value">Admin</p>
                            <p class="panel-label">Portal público</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.about') }}" class="panel-action">Ir a Portal</a>
                </section>
            </div>
        </main>
    </div>
</div>

@endsection

@section('styles')
<style>
    .dashboard-unified-container {
        animation: fadeIn 0.5s ease-out;
    }

    .admin-dashboard-layout {
        display: grid;
        grid-template-columns: 320px minmax(0, 1fr);
        gap: 28px;
        align-items: start;
    }

    .admin-dashboard-sidebar {
        background: #ffffff;
        border: 1px solid #e7eef3;
        border-radius: 32px;
        padding: 28px 20px;
        box-shadow: 0 24px 48px rgba(15, 23, 42, 0.08);
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
    }

    .sidebar-logo {
        width: 52px;
        height: 52px;
        border-radius: 18px;
        object-fit: contain;
        background: #f8fafc;
        padding: 10px;
    }

    .sidebar-brand h4 {
        margin: 0;
        font-size: 1.2rem;
        color: #102a43;
    }

    .sidebar-brand p {
        margin: 4px 0 0;
        font-size: 0.88rem;
        color: #52606d;
    }

    .sidebar-section {
        margin-top: 28px;
    }

    .sidebar-section-title {
        display: block;
        margin-bottom: 14px;
        color: #94a3b8;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        font-weight: 700;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
        padding: 14px 18px;
        border-radius: 18px;
        text-decoration: none;
        color: #102a43;
        background: #f8fafc;
        border: 1px solid transparent;
        font-weight: 700;
        transition: all 0.2s ease;
        margin-bottom: 10px;
    }

    .sidebar-link:hover {
        background: #eff6ff;
        border-color: #dbeafe;
    }

    .sidebar-link.active {
        background: linear-gradient(135deg, #2e8b57, #1f6c47);
        color: white;
        box-shadow: 0 12px 32px rgba(46, 139, 87, 0.18);
    }

    .link-icon {
        font-size: 1.3rem;
        line-height: 1;
    }

    .admin-dashboard-main {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section-header-premium {
        padding: 28px 32px;
        background: #ffffff;
        border: 1px solid #e7edf2;
        border-radius: 28px;
        box-shadow: 0 20px 44px rgba(15, 23, 42, 0.06);
    }

    .section-title {
        color: #102a43;
        font-size: 2.2rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .section-subtitle {
        color: #52606d;
        margin: 14px 0 0;
        font-size: 1rem;
        max-width: 720px;
        line-height: 1.75;
    }

    .dashboard-hero-card {
        padding: 28px 30px;
        border-radius: 28px;
        background: #ffffff;
        border: 1px solid #e7edf2;
        box-shadow: 0 24px 52px rgba(15, 23, 42, 0.06);
    }

    .hero-top-row {
        display: flex;
        justify-content: space-between;
        gap: 24px;
        align-items: flex-start;
    }

    .hero-label {
        display: inline-block;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #16a34a;
        margin-bottom: 12px;
    }

    .hero-title {
        font-size: 1.9rem;
        color: #102a43;
        margin: 0;
        line-height: 1.1;
    }

    .hero-description {
        color: #52606d;
        margin: 16px 0 0;
        font-size: 1rem;
        line-height: 1.7;
        max-width: 640px;
    }

    .hero-stat {
        min-width: 180px;
        padding: 22px 24px;
        border-radius: 24px;
        background: #f1f7f3;
        text-align: center;
        border: 1px solid #d8e8de;
    }

    .hero-stat span {
        display: block;
        color: #64748b;
        font-size: 0.85rem;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }

    .hero-stat strong {
        display: block;
        font-size: 2.4rem;
        color: #134e4a;
        margin-top: 6px;
    }

    .dashboard-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .summary-card {
        background: #ffffff;
        border: 1px solid #e7eef3;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.06);
        min-height: 160px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .page-panel {
        display: block;
    }

    .page-panel.hidden {
        display: none;
    }

    .panel-header {
        margin-bottom: 28px;
    }

    .panel-header h3 {
        font-size: 1.8rem;
        margin: 0 0 10px;
        color: #102a43;
    }

    .panel-header p {
        margin: 0;
        color: #52606d;
        line-height: 1.7;
        font-size: 1rem;
    }

    .panel-card {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 24px;
        border-radius: 24px;
        background: #f8fafc;
        border: 1px solid #e2edf1;
        margin-bottom: 24px;
    }

    .panel-card-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        background: #e6f3eb;
        display: grid;
        place-items: center;
        font-size: 1.5rem;
        color: #2e8b57;
    }

    .panel-value {
        margin: 0;
        font-size: 2.1rem;
        color: #102a43;
        font-weight: 800;
    }

    .panel-label {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 0.95rem;
    }

    .panel-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: fit-content;
        padding: 12px 22px;
        border-radius: 999px;
        background: #2e8b57;
        color: white;
        text-decoration: none;
        font-weight: 700;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .panel-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(46, 139, 87, 0.18);
    }

    .summary-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        font-size: 1.4rem;
        background: #ecfdf5;
        color: #15803d;
    }

    .summary-card h4 {
        margin: 0;
        font-size: 1rem;
        color: #102a43;
        font-weight: 700;
    }

    .summary-card p {
        margin: 0;
        color: #52606d;
        line-height: 1.7;
        font-size: 0.95rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 1120px) {
        .admin-dashboard-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 900px) {
        .hero-top-row {
            flex-direction: column;
        }

        .hero-stat {
            width: 100%;
        }
    }

    @media (max-width: 640px) {
        .admin-dashboard-sidebar,
        .section-header-premium,
        .dashboard-hero-card,
        .summary-card {
            padding: 20px;
        }

        .section-title {
            font-size: 1.8rem;
        }
    }
</style>
@endsection
