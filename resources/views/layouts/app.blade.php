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
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/a.png') }}" alt="Logo">
            <h2>@yield('panel-title', 'SDAANIM')</h2>
        </div>
        <div class="auth-info">
            @auth
            <span>{{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
            @else
            <a href="{{ route('login') }}">Iniciar sesión</a>
            @endauth
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer style="--footer-bg: @yield('footer-bg', '#007acc');">
        <p>© 2025 Esperanza Animal BQ | @yield('footer-text', 'SDAANIM')</p>
    </footer>
</body>

</html>