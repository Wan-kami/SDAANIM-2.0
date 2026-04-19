<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SDAANIM</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/styles.css') }}">
    @yield('styles')
</head>

<body>
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
                <span class="header-username">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="header-logout-btn" title="Cerrar sesión">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="header-login-btn">Iniciar sesión</a>
            @endauth
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer style="--footer-bg: @yield('footer-bg', '#007acc');">
        <p>© 2025 Esperanza Animal BQ | @yield('footer-text', 'SDAANIM')</p>
    </footer>

    <style>
        .admin-header-professional {
            background: linear-gradient(90deg, #2e8b57, #4caf50);
            color: white;
            padding: 12px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-logo {
            height: 45px;
            width: auto;
        }

        .header-title {
            font-family: 'Pacifico', cursive;
            font-size: 1.5em;
            margin: 0;
            color: #1a1a1a;
            font-weight: 600;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-notif-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .header-notif-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .notif-icon {
            font-size: 1.1rem;
        }

        .notif-text {
            display: inline;
        }

        .header-divider {
            width: 1px;
            height: 24px;
            background: rgba(255, 255, 255, 0.3);
        }

        .header-username {
            font-weight: 600;
            font-size: 0.95rem;
            min-width: 120px;
            text-align: right;
        }

        .logout-form {
            margin: 0;
            display: inline;
        }

        .header-logout-btn {
            background: none;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 600;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: rgba(255, 255, 255, 0.1);
        }

        .header-logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .header-login-btn {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            display: inline-block;
        }

        .header-login-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .admin-header-professional {
                flex-direction: column;
                gap: 12px;
            }

            .header-right {
                width: 100%;
                justify-content: space-between;
            }

            .header-username {
                text-align: center;
            }

            .notif-text {
                display: none;
            }
        }

        /* Notification Sidebar Styles */
        .notif-sidebar {
            position: fixed;
            top: 0;
            right: -320px;
            width: 300px;
            height: 100%;
            background-color: #ffffff;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
            transition: right 0.4s ease;
            z-index: 1000;
            padding: 20px;
            overflow-y: auto;
        }

        .notif-sidebar.active {
            right: 0;
        }

        .notif-sidebar h3 {
            color: #2e8b57;
            text-align: center;
            margin-bottom: 20px;
            margin-top: 30px;
        }

        .notif-sidebar a {
            display: block;
            padding: 12px;
            color: #333;
            border-bottom: 1px solid #eee;
            transition: 0.3s;
            border-radius: 5px;
            text-decoration: none;
        }

        .notif-sidebar a:hover {
            background-color: #e9f7ef;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #2e8b57;
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