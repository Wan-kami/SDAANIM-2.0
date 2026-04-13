<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDAANIM - Registro</title>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/mm.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/modal.css') }}">
</head>

<body>
    <header class="main-header">
        <div class="header-top">
            <div class="logo">
                <img src="{{ asset('img/a.png') }}" alt="logo">
                <span>Esperanza Animal BQ</span>
            </div>

            <nav class="nav-menu">
                <a href="{{ url('/') }}">Inicio</a>
                <a href="{{ route('about') }}">Quienes somos</a>
                <a href="{{ route('adopta') }}">Adopta</a>
                <a href="{{ route('products.public') }}">Productos</a>

                <div class="dropdown">
                    <a href="#" class="dropbtn">Apóyanos ▾</a>
                    <div class="dropdown-content">
                        <a href="{{ route('inscriptions.volunteer') }}">Voluntario</a>
                        <a href="{{ route('inscriptions.veterinarian') }}">Veterinario</a>
                    </div>
                </div>
            </nav>

            <div class="search-container">
                <nav class="nav-right">
                    <button onclick="window.location.href='{{ route('login') }}'" class="filtro">Iniciar Sesión</button>
                </nav>
                <div class="usuario">
                    <a href="#"><img src="{{ asset('img/usuario.png') }}" alt="Usuario" id="usuario-icon"></a>
                </div>
            </div>
        </div>
    </header>

    <br><br><br>

    <div class="login-container">
        <h2>Crear Cuenta</h2>
        <form action="{{ route('register.custom') }}" method="POST">
            @csrf
            <input
                type="text"
                name="Usu_documento"
                placeholder="Número de Documento"
                value="{{ old('Usu_documento') }}"
                required />
            @error('Usu_documento') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <input
                type="text"
                name="name"
                placeholder="Nombre Completo"
                value="{{ old('name') }}"
                required />
            @error('name') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <input
                type="email"
                name="email"
                placeholder="Correo Electrónico"
                value="{{ old('email') }}"
                required />
            @error('email') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <input
                type="text"
                name="Usu_telefono"
                placeholder="Número de Teléfono"
                value="{{ old('Usu_telefono') }}"
                required />
            @error('Usu_telefono') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <input
                type="text"
                name="Usu_direccion"
                placeholder="Dirección"
                value="{{ old('Usu_direccion') }}"
                required />
            @error('Usu_direccion') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <div style="position: relative; width: 100%; margin-bottom: 0.85rem;">
                <input
                    type="password"
                    name="password"
                    id="register-password"
                    placeholder="Contraseña"
                    required
                    style="width: 100%; padding-right: 42px;"
                />
                <button type="button" onclick="togglePasswordVisibility('register-password', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: transparent; cursor: pointer; font-size: 1.1rem;">👁️</button>
            </div>
            @error('password') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <div style="position: relative; width: 100%; margin-bottom: 0.85rem;">
                <input
                    type="password"
                    name="password_confirmation"
                    id="register-password_confirmation"
                    placeholder="Confirmar Contraseña"
                    required
                    style="width: 100%; padding-right: 42px;"
                />
                <button type="button" onclick="togglePasswordVisibility('register-password_confirmation', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: transparent; cursor: pointer; font-size: 1.1rem;">👁️</button>
            </div>

            <button type="submit" class="btn">Registrarse</button>
        </form>

        <div class="social-login">
            <button class="google-btn">Registrarse con Google</button>
            <button class="facebook-btn">Registrarse con Facebook</button>
        </div>

        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
        <br>
        <a href="{{ url('/') }}" class="btn volver-btn">Regresar</a>
    </div>

    <script>
        function togglePasswordVisibility(fieldId, button) {
            const input = document.getElementById(fieldId);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                button.textContent = '🙈';
            } else {
                input.type = 'password';
                button.textContent = '👁️';
            }
        }
    </script>
    @if(session('mostrar_modal') || session('error'))
    <div class="modal-overlay active">
        <div class="modal-box">

            <h3>Verifica tu correo 📩</h3>
            <p>Ingresa el código que te enviamos</p>

            {{-- 🔥 MENSAJE DE ERROR --}}
            @if(session('error'))
            <p style="color:red; margin-top:10px; font-weight:bold;">
                {{ session('error') }}
            </p>
            @endif

            <form action="{{ url('/verificar') }}" method="POST">
                @csrf

                <input
                    type="text"
                    name="codigo"
                    placeholder="Código de 6 dígitos"
                    style="margin-top:15px; text-align:center; font-size:18px;"
                    required>

                <button type="submit" class="btn" style="margin-top:15px;">
                    Verificar
                </button>
            </form>

        </div>
    </div>
    @endif
</body>

</html>