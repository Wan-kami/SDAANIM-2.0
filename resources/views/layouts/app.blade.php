<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SDAANIM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/admin-unified.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/premium-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/modal-foto.css') }}">
    
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