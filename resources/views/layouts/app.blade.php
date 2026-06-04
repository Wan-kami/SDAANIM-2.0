<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SDAANIM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/modal-foto.css') }}">
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
                @php
                    $notifCount = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)
                        ->whereNull('read_at')
                        ->count();
                @endphp
                <button type="button" class="header-notif-btn" onclick="toggleSidebar()" title="Abrir notificaciones">
                    <span class="notif-text">Notificaciones</span>
                    <span class="notif-bell">🔔</span>
                    @if($notifCount > 0)
                        <span class="notif-badge-dot"></span>
                    @endif
                </button>

                <div class="header-profile-container">
                    <a href="{{ route('profile.edit') }}" class="header-username" title="Ver mi perfil">
                        <span class="user-name-text">{{ Auth::user()->name }}</span>
                        <img src="{{ Auth::user()->Usu_foto ? asset('img/profiles/' . Auth::user()->Usu_foto) . '?v=' . time() : asset('img/default-avatar.png') }}" class="header-avatar" alt="Profile">
                    </a>
                </div>
                <form id="logoutForm-admin" action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="button" class="header-logout-btn" title="Cerrar sesión" onclick="confirmarLogout(event, 'logoutForm-admin')">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="header-login-btn">Iniciar sesión</a>
            @endauth
        </div>
    </header>

    <div id="notifSidebar" class="notif-sidebar">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Centro de Notificaciones</h3>

        @auth
            @php
                $adoptionNotifs = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)
                    ->where('Noti_mensaje', 'like', '%solicitud de adopción%')
                    ->orderBy('Noti_fecha', 'DESC')
                    ->get();
                
                $volunteerNotifs = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)
                    ->where('Noti_mensaje', 'like', '%Voluntario%')
                    ->orderBy('Noti_fecha', 'DESC')
                    ->get();
                
                $vetNotifs = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)
                    ->where('Noti_mensaje', 'like', '%Veterinario%')
                    ->orderBy('Noti_fecha', 'DESC')
                    ->get();
                
                $otherNotifs = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)
                    ->where('Noti_mensaje', 'not like', '%solicitud de adopción%')
                    ->where('Noti_mensaje', 'not like', '%Voluntario%')
                    ->where('Noti_mensaje', 'not like', '%Veterinario%')
                    ->orderBy('Noti_fecha', 'DESC')
                    ->take(5)
                    ->get();
            @endphp

            <!-- ADOPTION REQUESTS -->
            @if(count($adoptionNotifs) > 0)
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 2px solid #fde047;">
                    <h4 style="margin: 0; color: #f59e0b; font-weight: 700; font-size: 0.9rem;">🐕 SOLICITUDES ADOPCIÓN</h4>
                    <span class="sidebar-badge" style="background: #f59e0b; font-size: 0.7rem;">{{ count($adoptionNotifs) }}</span>
                </div>
                @foreach($adoptionNotifs->take(3) as $notif)
                <a href="{{ $notif->Noti_link ?? route('admin.adoptions') }}" data-notification-id="{{ $notif->Noto_id }}" class="notification-link" style="border-left: 3px solid #f59e0b; margin-bottom: 8px; font-size: 0.85em;">
                    {{ $notif->Noti_mensaje }}<br>
                    <small style="color: #999;">{{ \Carbon\Carbon::parse($notif->Noti_fecha)->diffForHumans() }}</small>
                </a>
                @endforeach
                @if(count($adoptionNotifs) > 3)
                <a href="{{ route('admin.adoptions') }}" style="display: block; text-align: center; color: #f59e0b; font-size: 0.8rem; margin-top: 8px; text-decoration: none; font-weight: 600;">Ver todas ({{ count($adoptionNotifs) }})</a>
                @endif
            </div>
            @endif

            <!-- VOLUNTEER REQUESTS -->
            @if(count($volunteerNotifs) > 0)
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 2px solid #a78bfa;">
                    <h4 style="margin: 0; color: #8b5cf6; font-weight: 700; font-size: 0.9rem;">👥 SOLICITUDES VOLUNTARIO</h4>
                    <span class="sidebar-badge" style="background: #8b5cf6; font-size: 0.7rem;">{{ count($volunteerNotifs) }}</span>
                </div>
                @foreach($volunteerNotifs->take(3) as $notif)
                <a href="{{ $notif->Noti_link ?? route('admin.volunteers') }}" data-notification-id="{{ $notif->Noto_id }}" class="notification-link" style="border-left: 3px solid #8b5cf6; margin-bottom: 8px; font-size: 0.85em;">
                    {{ $notif->Noti_mensaje }}<br>
                    <small style="color: #999;">{{ \Carbon\Carbon::parse($notif->Noti_fecha)->diffForHumans() }}</small>
                </a>
                @endforeach
                @if(count($volunteerNotifs) > 3)
                <a href="{{ route('admin.volunteers') }}" style="display: block; text-align: center; color: #8b5cf6; font-size: 0.8rem; margin-top: 8px; text-decoration: none; font-weight: 600;">Ver todas ({{ count($volunteerNotifs) }})</a>
                @endif
            </div>
            @endif

            <!-- VET REQUESTS -->
            @if(count($vetNotifs) > 0)
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 2px solid #4ade80;">
                    <h4 style="margin: 0; color: #22c55e; font-weight: 700; font-size: 0.9rem;">⚕️ SOLICITUDES VETERINARIO</h4>
                    <span class="sidebar-badge" style="background: #22c55e; font-size: 0.7rem;">{{ count($vetNotifs) }}</span>
                </div>
                @foreach($vetNotifs->take(3) as $notif)
                <a href="{{ $notif->Noti_link ?? route('admin.veterinarians') }}" data-notification-id="{{ $notif->Noto_id }}" class="notification-link" style="border-left: 3px solid #22c55e; margin-bottom: 8px; font-size: 0.85em;">
                    {{ $notif->Noti_mensaje }}<br>
                    <small style="color: #999;">{{ \Carbon\Carbon::parse($notif->Noti_fecha)->diffForHumans() }}</small>
                </a>
                @endforeach
                @if(count($vetNotifs) > 3)
                <a href="{{ route('admin.veterinarians') }}" style="display: block; text-align: center; color: #22c55e; font-size: 0.8rem; margin-top: 8px; text-decoration: none; font-weight: 600;">Ver todas ({{ count($vetNotifs) }})</a>
                @endif
            </div>
            @endif

            <!-- OTHER NOTIFICATIONS -->
            @if(count($otherNotifs) > 0)
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 2px solid #e5e7eb;">
                    <h4 style="margin: 0; color: #666; font-weight: 700; font-size: 0.9rem;">⚡ OTRAS NOTIFICACIONES</h4>
                </div>
                @foreach($otherNotifs as $notif)
                <a href="{{ $notif->Noti_link ?? '#' }}" data-notification-id="{{ $notif->Noto_id }}" class="notification-link" style="border-left: 3px solid #2196f3; margin-bottom: 8px; font-size: 0.85em;">
                    {{ $notif->Noti_mensaje }}<br>
                    <small style="color: #999;">{{ \Carbon\Carbon::parse($notif->Noti_fecha)->diffForHumans() }}</small>
                </a>
                @endforeach
            </div>
            @endif

            @if(count($adoptionNotifs) === 0 && count($volunteerNotifs) === 0 && count($vetNotifs) === 0 && count($otherNotifs) === 0)
            <p style="text-align: center; color: #999; font-size: 0.9em; padding: 20px;">✨ No tienes notificaciones pendientes.</p>
            @endif
        @else
            <p style="text-align: center; color: #999; font-size: 0.9em;">Inicia sesión para ver tus notificaciones.</p>
        @endauth

        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <div style="padding-top: 10px;">
            <a href="{{ route('notifications') }}" style="display: block; text-align: center; color: #2196f3; font-weight: bold; text-decoration: none; padding: 10px; border-radius: 6px; transition: all 0.2s; background: #f0f0f0;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f0f0f0'">
                📋 Ver Centro de Notificaciones
            </a>
        </div>
    </div>

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
            font-family: 'Inter', sans-serif;
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
            font-family: 'Merriweather', serif;
            font-size: 1.6rem;
            margin: 0;
            color: white;
            font-weight: 700;
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

        /* Notification Badges */
        .header-notif-btn { position: relative; }
        .notif-badge-dot {
            position: absolute;
            top: 8px;
            right: 12px;
            width: 10px;
            height: 10px;
            background-color: #ff4444;
            border-radius: 50%;
            border: 2px solid var(--admin-green);
        }

        .sidebar-item-with-badge {
            display: flex !important;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-badge {
            background: #ff4444;
            color: white;
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 800;
            box-shadow: 0 2px 5px rgba(255,68,68,0.3);
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
                @auth
                if (sidebar.classList.contains("active")) {
                    const badge = document.querySelector('.notif-badge-dot');
                    if (badge) {
                        fetch('{{ route("notificaciones.leer") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => {
                            if (response.ok) {
                                badge.style.display = 'none';
                            }
                        }).catch(error => console.error('Error:', error));
                    }
                }
                @endauth
            }
        }

        // Funciones para modal de foto de perfil
        function abrirModalFoto(img) {
            const modal = document.getElementById('modalFoto');
            const modalImg = document.getElementById('modalFotoImg');
            if (modal && img) {
                modalImg.src = img.src;
                modal.classList.add('activo');
                document.body.style.overflow = 'hidden';
            }
        }

        function cerrarModalFoto(event) {
            const modal = document.getElementById('modalFoto');
            if (modal) {
                // Si se hace clic en el fondo, cerrar
                if (!event || event.target === modal || event.target.classList.contains('cerrar-modal-foto')) {
                    modal.classList.remove('activo');
                    document.body.style.overflow = 'auto';
                }
            }
        }

        // Cerrar modal con tecla ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                cerrarModalFoto();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const notificationLinks = document.querySelectorAll('.notification-link');
            notificationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const notificationId = this.getAttribute('data-notification-id');
                    const href = this.getAttribute('href');
                    const linkElement = this;

                    fetch(`/notifications/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            linkElement.style.opacity = '0';
                            linkElement.style.transition = 'opacity 0.3s ease';
                            setTimeout(() => {
                                if (linkElement.parentElement) {
                                    linkElement.remove();
                                }
                                if (href && href !== '#') {
                                    window.location.href = href;
                                }
                            }, 300);
                        }
                    })
                    .catch(error => {
                        console.error('Error al eliminar notificación:', error);
                        if (href && href !== '#') {
                            window.location.href = href;
                        }
                    });
                });
            });
        });
    </script>
    @include('partials.logout_modal')
</body>

</html>