@extends('layouts.app')

@section('content')
<div class="admin-header">
    <div class="logo">
        <img src="{{ asset('img/a.png') }}" alt="Logo">
        <h2>Panel Administrador</h2>
    </div>
    <div>
        <button class="notif-toggle" onclick="toggleSidebar()">🔔 Notificaciones</button>
    </div>
</div>

<div id="notifSidebar" class="notif-sidebar">
    <button class="close-btn" onclick="toggleSidebar()">✖</button>
    <h3>Notificaciones</h3>
    <a href="{{ route('admin.notifications') }}">📋 Ver todas</a>
    <a href="{{ route('admin.volunteers') }}">📋 Nuevos voluntarios postulados</a>
    <a href="{{ route('admin.adoptants') }}">🐾 Adoptantes registrados</a>
    <a href="{{ route('admin.veterinarians') }}">⚕️ Veterinarios postulados</a>
    <a href="{{ route('admin.adoptions') }}">Adopciones enviadas</a>
</div>

<main>
    <section class="admin-sections">
        <div class="admin-card">
            <div class="icon">🐶</div>
            <h3>Animales</h3>
            <p>Gestiona animales en adopción y agrega nuevas fotos o perfiles.</p>
            <p><strong>Total: {{ $stats['animals'] ?? 0 }}</strong></p>
            <a href="{{ route('admin.animals') }}">Gestionar</a>
        </div>

        <div class="admin-card">
            <div class="icon">🛒</div>
            <h3>Productos</h3>
            <p>Gestiona los productos disponibles y su información.</p>
            <p><strong>Total: {{ $stats['products'] ?? 0 }}</strong></p>
            <a href="{{ route('admin.products') }}">Gestionar</a>
        </div>

        <div class="admin-card">
            <div class="icon">🐕</div>
            <h3>Solicitudes de Adopción</h3>
            <p>Revisar y gestionar las solicitudes pendientes.</p>
            <p><strong>Pendientes: {{ $stats['adoptions'] ?? 0 }}</strong></p>
            <a href="{{ route('admin.adoptions') }}">Ver Solicitudes</a>
        </div>

        <div class="admin-card">
            <div class="icon">⚕️</div>
            <h3>Veterinarios</h3>
            <p>Agenda citas, revisa solicitudes y coordina atenciones médicas.</p>
            <p><strong>Total: {{ $stats['veterinarians'] ?? 0 }}</strong></p>
            <a href="{{ route('admin.veterinarians') }}">Ver Veterinarios</a>
        </div>

        <div class="admin-card">
            <div class="icon">👥</div>
            <h3>Voluntarios</h3>
            <p>Gestiona las inscripciones de voluntarios.</p>
            <p><strong>Total: {{ $stats['volunteers'] ?? 0 }}</strong></p>
            <a href="{{ route('admin.volunteers') }}">Ver Voluntarios</a>
        </div>

        <div class="admin-card">
            <div class="icon">📋</div>
            <h3>Adoptantes</h3>
            <p>Ver y gestionar los adoptantes registrados.</p>
            <p><strong>Total: {{ $stats['adoptants'] ?? 0 }}</strong></p>
            <a href="{{ route('admin.adoptants') }}">Ver Adoptantes</a>
        </div>

        <div class="admin-card">
            <div class="icon">📅</div>
            <h3>Citas Veterinarias</h3>
            <p>Agenda y gestiona las citas veterinarias.</p>
            <a href="{{ route('admin.appointments') }}">Ver Citas</a>
        </div>

        <div class="admin-card">
            <div class="icon">📊</div>
            <h3>Tareas</h3>
            <p>Gestiona las tareas del sistema.</p>
            <p><strong>Pendientes: {{ $stats['tasks'] ?? 0 }}</strong></p>
            <a href="{{ route('admin.tasks') }}">Ver Tareas</a>
        </div>

        <div class="admin-card">
            <div class="icon">📦</div>
            <h3>Reservas</h3>
            <p>Gestionar las reservas de productos.</p>
            <a href="{{ route('admin.reservations') }}">Ver Reservas</a>
        </div>

        <div class="admin-card">
            <div class="icon">💰</div>
            <h3>Donaciones</h3>
            <p>Ver el historial de donaciones.</p>
            <p><strong>Total: ${{ number_format($stats['donations'] ?? 0, 0) }}</strong></p>
            <a href="{{ route('admin.donations') }}">Ver Donaciones</a>
        </div>

        <div class="admin-card">
            <div class="icon">🏥</div>
            <h3>Historial Médico</h3>
            <p>Ver el historial médico de los animales.</p>
            <a href="{{ route('admin.medical') }}">Ver Historial</a>
        </div>

        <div class="admin-card">
            <div class="icon">📝</div>
            <h3>Quiénes Somos</h3>
            <p>Editar misión, visión y valores del refugio.</p>
            <a href="{{ route('admin.about') }}">Editar</a>
        </div>
    </section>
</main>

<footer>
    <p>© 2025 Esperanza Animal BQ | Panel Administrador</p>
</footer>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("notifSidebar");
        sidebar.classList.toggle("active");
    }
</script>
@endsection
