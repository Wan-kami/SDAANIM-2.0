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
    <div class="section-header-premium">
        <h3 class="section-title">Gestión de SDAANIM</h3>
        <p class="section-subtitle">Panel principal para la administración de refugios, voluntarios y servicios médicos.</p>
    </div>

    <section class="admin-sections-grid">
        <div class="admin-card-premium">
            <div class="card-icon">🐶</div>
            <div class="card-body">
                <h3>Animales</h3>
                <p>Gestiona animales en adopción y agrega nuevas fotos o perfiles.</p>
                <div class="card-stat">
                    <span class="stat-label">Total registrados:</span>
                    <span class="stat-value">{{ $stats['animals'] ?? 0 }}</span>
                </div>
            </div>
            <a href="{{ route('admin.animals') }}" class="btn-card-action">Gestionar</a>
        </div>

        <div class="admin-card-premium">
            <div class="card-icon">🛒</div>
            <div class="card-body">
                <h3>Productos</h3>
                <p>Gestiona los productos disponibles y su información.</p>
                <div class="card-stat">
                    <span class="stat-label">Inventario:</span>
                    <span class="stat-value">{{ $stats['products'] ?? 0 }}</span>
                </div>
            </div>
            <a href="{{ route('admin.products') }}" class="btn-card-action">Gestionar</a>
        </div>

        <div class="admin-card-premium">
            <div class="card-icon">🐕</div>
            <div class="card-body">
                <h3>Solicitudes</h3>
                <p>Revisar y gestionar las solicitudes pendientes de adopción.</p>
                <div class="card-stat">
                    <span class="stat-label">Pendientes:</span>
                    <span class="stat-value urgent">{{ $stats['adoptions'] ?? 0 }}</span>
                </div>
            </div>
            <a href="{{ route('admin.adoptions') }}" class="btn-card-action">Ver Solicitudes</a>
        </div>

        <div class="admin-card-premium">
            <div class="card-icon">⚕️</div>
            <div class="card-body">
                <h3>Veterinarios</h3>
                <p>Agenda citas, revisa solicitudes y coordina atenciones médicas.</p>
                <div class="card-stat">
                    <span class="stat-label">Especialistas:</span>
                    <span class="stat-value">{{ $stats['veterinarians'] ?? 0 }}</span>
                </div>
            </div>
            <a href="{{ route('admin.veterinarians') }}" class="btn-card-action">Ver Veterinarios</a>
        </div>

        <div class="admin-card-premium">
            <div class="card-icon">👥</div>
            <div class="card-body">
                <h3>Voluntarios</h3>
                <p>Gestiona las inscripciones de voluntarios y equipos.</p>
                <div class="card-stat">
                    <span class="stat-label">Equipo actual:</span>
                    <span class="stat-value">{{ $stats['volunteers'] ?? 0 }}</span>
                </div>
            </div>
            <a href="{{ route('admin.volunteers') }}" class="btn-card-action">Ver Voluntarios</a>
        </div>

        <div class="admin-card-premium">
            <div class="card-icon">📋</div>
            <div class="card-body">
                <h3>Adoptantes</h3>
                <p>Ver y gestionar los adoptantes registrados en el sistema.</p>
                <div class="card-stat">
                    <span class="stat-label">Registrados:</span>
                    <span class="stat-value">{{ $stats['adoptants'] ?? 0 }}</span>
                </div>
            </div>
            <a href="{{ route('admin.adoptants') }}" class="btn-card-action">Ver Adoptantes</a>
        </div>

        <div class="admin-card-premium">
            <div class="card-icon">📦</div>
            <div class="card-body">
                <h3>Pedidos</h3>
                <p>Revisa los pedidos realizados por los usuarios y su estado.</p>
                <div class="card-stat">
                    <span class="stat-label">Total pedidos:</span>
                    <span class="stat-value">{{ $stats['orders'] ?? 0 }}</span>
                </div>
            </div>
            <a href="{{ route('admin.orders') }}" class="btn-card-action">Ver Pedidos</a>
        </div>

        <div class="admin-card-premium">
            <div class="card-icon">📊</div>
            <div class="card-body">
                <h3>Tareas</h3>
                <p>Gestiona las tareas asignadas y el flujo del sistema.</p>
                <div class="card-stat">
                    <span class="stat-label">Pendientes hoy:</span>
                    <span class="stat-value">{{ $stats['tasks'] ?? 0 }}</span>
                </div>
            </div>
            <a href="{{ route('admin.tasks') }}" class="btn-card-action">Ver Tareas</a>
        </div>

        <div class="admin-card-premium">
            <div class="card-icon">🏥</div>
            <div class="card-body">
                <h3>Médico</h3>
                <p>Ver el historial médico detallado de todos los animales.</p>
                <div class="card-stat">
                    <span class="stat-label">Estado de salud:</span>
                    <span class="stat-value">Activo</span>
                </div>
            </div>
            <a href="{{ route('admin.medical') }}" class="btn-card-action">Ver Historial</a>
        </div>

        <div class="admin-card-premium">
            <div class="card-icon">📝</div>
            <div class="card-body">
                <h3>Portal</h3>
                <p>Editar misión, visión y valores públicos del refugio.</p>
                <div class="card-stat">
                    <span class="stat-label">Contenido:</span>
                    <span class="stat-value">Educativo</span>
                </div>
            </div>
            <a href="{{ route('admin.about') }}" class="btn-card-action">Configurar</a>
        </div>

        <div class="admin-card-premium">
            <div class="card-icon">🔔</div>
            <div class="card-body">
                <h3>Notificaciones</h3>
                <p>Revisa los avisos recientes del sistema y las alertas importantes.</p>
                <div class="card-stat">
                    <span class="stat-label">Acceso rápido:</span>
                    <span class="stat-value">Mensajes</span>
                </div>
            </div>
            <a href="{{ route('admin.notifications') }}" class="btn-card-action">Ver Notificaciones</a>
        </div>
    </section>
</div>

@endsection

@section('styles')
<style>
    .dashboard-unified-container {
        animation: fadeIn 0.6s ease-out;
    }

    .section-header-premium {
        margin-bottom: 40px;
        border-left: 5px solid var(--admin-green);
        padding-left: 20px;
    }

    .section-title {
        color: #1e293b;
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .section-subtitle {
        color: #64748b;
        margin: 5px 0 0 0;
        font-size: 1.1rem;
    }

    .admin-sections-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    .admin-card-premium {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .admin-card-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        border-color: #cbd5e1;
    }

    .card-icon {
        font-size: 2.5rem;
        margin-bottom: 20px;
        background: #f8fafc;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
    }

    .card-body h3 {
        color: #1e293b;
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0 0 12px 0;
    }

    .card-body p {
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }

    .card-stat {
        background: #f1f5f9;
        padding: 8px 15px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
    }

    .stat-value {
        font-weight: 800;
        color: var(--admin-green);
    }

    .stat-value.urgent {
        color: #ef4444;
    }

    .btn-card-action {
        margin-top: auto;
        display: block;
        background: #f8fafc;
        color: var(--admin-green);
        text-decoration: none;
        text-align: center;
        padding: 12px;
        border-radius: 12px;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .btn-card-action:hover {
        background: var(--admin-green);
        color: white;
        border-color: var(--admin-green);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 640px) {
        .admin-sections-grid { grid-template-columns: 1fr; }
        .section-title { font-size: 1.6rem; }
    }
</style>
@endsection
