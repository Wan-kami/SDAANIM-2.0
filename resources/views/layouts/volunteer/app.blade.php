<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Panel Voluntario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/premium.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/modal-foto.css') }}">
    <link rel="stylesheet" href="{{ asset('css/volunteer/dashboard.css') }}">
    @yield('styles')
</head>
<body>
    <header class="vol-header admin-header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('img/a.png') }}" alt="Logo" style="height: 45px;">
            <h2 class="logo-text">SDAANIM Voluntarios</h2>
        </div>
        <div style="display: flex; align-items: center; gap: 15px;">
            @php
                $notifCount = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->whereNull('read_at')->count();
            @endphp
            <div style="position: relative; display: inline-block;">
                <button type="button" class="notif-toggle" onclick="toggleSidebar()" style="background: none; border: none; font-size: 1.4em; cursor: pointer; padding: 0;">🔔</button>
                @if($notifCount > 0)
                    <span id="notifBadge" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7em; font-weight: bold;">{{ $notifCount }}</span>
                @endif
            </div>
            <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;" title="Ir a mi perfil">
                <img src="{{ Auth::user()->Usu_foto ? asset('img/profiles/' . Auth::user()->Usu_foto) : asset('img/usuario.png') }}" alt="Perfil" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <span style="font-weight:bold;">{{ Auth::user()->name }}</span>
            </a>
            <div style="width: 1px; height: 30px; background: rgba(0,0,0,0.1); margin: 0 5px;"></div>
            <form id="logoutForm-volunteer-header" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="button" onclick="confirmarLogout(event, 'logoutForm-volunteer-header')" style="background:#ef4444; color:white; border:none; padding:8px 15px; border-radius:6px; font-weight:bold; cursor:pointer;" title="Cerrar sesión">Cerrar sesión</button>
            </form>
        </div>
    </header>

    <div id="notifSidebar" class="notif-sidebar sidebar-vol">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Centro de Avisos</h3>
        <div style="margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;" id="notificationContainer">
            @auth
                @forelse(\App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->latest()->take(5)->get() as $notification)
                    <a href="{{ $notification->Noti_link ?? '#' }}" data-notification-id="{{ $notification->Noto_id }}" class="notification-link" style="font-size: 0.9em; border-left: 3px solid #007acc; margin-bottom: 5px; background: #f0f7ff;">
                        {{ $notification->Noti_mensaje }}<br>
                        <small style="color: #999;">{{ \Carbon\Carbon::parse($notification->Noti_fecha)->diffForHumans() }}</small>
                    </a>
                @empty
                    <p style="text-align: center; color: #999; font-size: 0.9em;">Sin tareas pendientes hoy.</p>
                @endforelse
            @endauth
        </div>
        <h3>Mi Gestión</h3>
        <a href="{{ route('volunteer.dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('volunteer.tasks') }}">📝 Mis Tareas</a>
        <a href="{{ route('profile.edit') }}">📊 Mi Perfil</a>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <a href="#" style="color: #666; font-weight: bold;">❓ Ayuda y Soporte</a>
        <form id="logoutForm-volunteer-sidebar" action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
            @csrf
            <button type="button" onclick="confirmarLogout(event, 'logoutForm-volunteer-sidebar')" style="width: 100%; text-align: left; padding: 12px; background: transparent; border: none; cursor: pointer; color: #d9534f; font-size: 0.9em; border-radius: 5px; font-family: inherit; transition: 0.3s;" onmouseover="this.style.backgroundColor='#ffe6e6'" onmouseout="this.style.backgroundColor='transparent'">
                🚪 Cerrar sesión
            </button>
        </form>
    </div>

    <main>
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; margin: 20px auto; max-width: 1100px; border-radius: 8px; text-align: center; font-weight: bold;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('welcome'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    title: 'Bienvenido',
                    text: "{{ session('welcome') }}",
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            </script>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>© 2025 Esperanza Animal BQ | Panel Voluntario</p>
    </footer>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("notifSidebar");
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                const badge = document.getElementById("notifBadge");
                if (badge) {
                    fetch('{{ route("notificaciones.leer") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => {
                        if(response.ok) {
                            badge.style.display = 'none';
                        }
                    }).catch(error => console.error('Error:', error));
                }
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
                        if(response.ok) {
                            linkElement.style.opacity = '0';
                            linkElement.style.transition = 'opacity 0.3s ease';
                            setTimeout(() => {
                                if (linkElement.parentElement) {
                                    linkElement.remove();
                                }
                            }, 300);
                            
                            if (href && href !== '#') {
                                setTimeout(() => {
                                    window.location.href = href;
                                }, 300);
                            }
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
