<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SDAANIM</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans:wght@400;600&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/styles.css') }}">
    @yield('styles')
</head>

<body class="admin-unified-layout">
    <header class="admin-header-professional">
        <div class="header-left">
            <div class="logo-section">
                <img src="{{ asset('img/a.png') }}" alt="Logo" class="header-logo">
                <h2 class="header-title">@yield('panel-title', 'SDAANIM')</h2>
            </div>
        </div>

        <div class="header-right">
            @auth
                <button class="header-notif-btn" onclick="toggleSidebar()" title="Notificaciones">
                    <span class="notif-icon">🔔</span>
                    <span class="notif-text">Notificaciones</span>
                </button>
                <div class="header-divider"></div>
                <div class="header-profile-container">
                    <a href="{{ route('profile.edit') }}" class="header-username" title="Ver mi perfil">
                        <span class="user-name-text">{{ Auth::user()->name }}</span>
                        <img src="{{ Auth::user()->Usu_foto ? asset('img/profiles/' . Auth::user()->Usu_foto) . '?v=' . time() : asset('img/default-avatar.png') }}" class="header-avatar" alt="Profile">
                    </a>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="header-logout-btn" title="Cerrar sesión">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="header-login-btn">Iniciar sesión</a>
            @endauth
        </div>
    </header>

    <main class="main-content-area">
        <div class="container-fluid content-container">
            @yield('content')
        </div>
    </main>

    <footer class="main-footer-professional">
        <div class="footer-content">
            <div class="footer-brand">
                <span class="brand-text">Esperanza Animal BQ</span>
            </div>
            <div class="footer-copyright">
                <p>&copy; 2025 | @yield('footer-text', 'Sistema de Gestión SDAANIM')</p>
            </div>
            <div class="footer-status">
                <span class="status-indicator"></span>
                <span>Sistema Operativo</span>
            </div>
        </div>
    </footer>

    <!-- Sidebar de Notificaciones (Global) -->
    <div id="notifSidebar" class="notif-sidebar">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Notificaciones</h3>
        <a href="{{ route('admin.notifications') }}">📋 Ver todas</a>
        <a href="{{ route('admin.volunteers') }}">📋 Nuevos voluntarios postulados</a>
        <a href="{{ route('admin.adoptants') }}">🐾 Adoptantes registrados</a>
        <a href="{{ route('admin.veterinarians') }}">⚕️ Veterinarios postulados</a>
        <a href="{{ route('admin.adoptions') }}">Adopciones enviadas</a>
    </div>

    <style>
        :root {
            --admin-green: #2e8b57;
            --admin-green-light: #4caf50;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        * {
            box-sizing: border-box;
        }

        body.admin-unified-layout {
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'Open Sans', sans-serif;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Professional Header */
        .admin-header-professional {
            background: linear-gradient(135deg, var(--admin-green), var(--admin-green-light));
            color: white;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            height: 70px;
        }

        .header-left, .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-logo {
            height: 48px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .header-title {
            font-family: 'Pacifico', cursive;
            font-size: 1.6rem;
            margin: 0;
            color: white;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-notif-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .header-notif-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .header-divider {
            width: 1px;
            height: 30px;
            background: rgba(255, 255, 255, 0.2);
        }

        .header-username {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .header-username:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .header-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .header-logout-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 18px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .header-logout-btn:hover {
            background: #ef4444;
            border-color: #ef4444;
            transform: translateY(-2px);
        }

        /* Unified Main Area */
        .main-content-area {
            flex: 1;
            padding: 40px 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .content-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Resets for existing section margins if any */
        .admin-sections {
            margin-top: 0 !important;
        }

        /* Modern Footer */
        .main-footer-professional {
            background: #1e293b;
            color: #94a3b8;
            padding: 30px 0;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-text {
            color: white;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            background: #22c55e;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(34, 197, 94, 0.6);
        }

        /* Sidebar Styles (Moved to Layout for consistency) */
        .notif-sidebar {
            position: fixed;
            top: 0;
            right: -350px;
            width: 320px;
            height: 100%;
            background: white;
            box-shadow: -5px 0 25px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            padding: 40px 25px;
        }

        .notif-sidebar.active {
            right: 0;
        }

        .notif-sidebar h3 {
            color: var(--admin-green);
            font-size: 1.4rem;
            margin-bottom: 25px;
            border-bottom: 2px solid var(--bg-light);
            padding-bottom: 15px;
        }

        .notif-sidebar a {
            display: block;
            padding: 15px;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 10px;
            transition: all 0.2s ease;
            background: #f8fafc;
            font-weight: 600;
        }

        .notif-sidebar a:hover {
            background: #e9f7ef;
            color: var(--admin-green);
            transform: translateX(-5px);
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .header-title { font-size: 1.3rem; }
            .notif-text { display: none; }
        }

        @media (max-width: 768px) {
            .admin-header-professional { height: auto; padding: 15px; flex-direction: column; gap: 15px; }
            .header-right { width: 100%; justify-content: space-between; }
            .footer-content { flex-direction: column; gap: 20px; text-align: center; }
        }
    </style>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("notifSidebar");
            if (sidebar) {
                sidebar.classList.toggle("active");
            }
        }
    </script>
</body>

</html>