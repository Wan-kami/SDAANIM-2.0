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
            <a href="{{ route('vet.dashboard') }}" class="nav-link-item {{ request()->routeIs('vet.dashboard') ? 'active' : '' }}">
                <span class="nav-item-icon">🏠</span>
                <span class="nav-item-label">Dashboard</span>
            </a>
        </div>

        <div class="nav-group-section">
            <p class="nav-group-title">MÓDULOS CLÍNICOS</p>
            <a href="{{ route('vet.animals') }}" class="nav-link-item {{ request()->routeIs('vet.animals*') ? 'active' : '' }}">
                <span class="nav-item-icon">🐾</span>
                <span class="nav-item-label">Animales</span>
            </a>
            <a href="{{ route('vet.tasks') }}" class="nav-link-item {{ request()->routeIs('vet.tasks*') ? 'active' : '' }}">
                <span class="nav-item-icon">📝</span>
                <span class="nav-item-label">Mis Tareas</span>
            </a>
            <a href="{{ route('vet.progress') }}" class="nav-link-item {{ request()->routeIs('vet.progress*') ? 'active' : '' }}">
                <span class="nav-item-icon">📈</span>
                <span class="nav-item-label">Mi Progreso</span>
            </a>
        </div>
    </nav>

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
