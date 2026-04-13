<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDAANIM - Login</title>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/mm.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/modal.css') }}">
</head>
<body>
    <!-- HEADER COMPLETO -->
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
                    <button onclick="window.location.href='{{ route('register') }}'" class="filtro">Registrarse</button>
                </nav>
                <div class="usuario">
                    <a href="#"><img src="{{ asset('img/usuario.png') }}" alt="Usuario" id="usuario-icon"></a>
                </div>
            </div>
        </div>
    </header>

    <br><br><br><br>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; margin: 0 auto 20px; max-width: 400px; border-radius: 8px; text-align: center; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; margin: 0 auto 20px; max-width: 400px; border-radius: 8px; text-align: center; font-weight: bold;">
            {{ session('error') }}
        </div>
    @endif

    <!-- LOGIN -->
    <div class="login-wrapper">
        <div class="login-container">
            <h2>Inicia Sesión</h2>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input
                    type="text"
                    name="Usu_documento"
                    placeholder="Número de Documento"
                    value="{{ old('Usu_documento') }}"
                    required
                    autofocus
                />
                @error('Usu_documento')
                    <p class="input-error">{{ $message }}</p>
                @enderror

                <div class="password-field">
                    <input
                        type="password"
                        name="password"
                        id="login-password"
                        placeholder="Contraseña"
                        required
                    />
                    <button type="button" onclick="togglePasswordVisibility('login-password', this)" class="eye-toggle">👁️</button>
                </div>
                @error('password')
                    <p class="input-error">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn" name="login">Ingresar</button>
            </form>

        <button type="button" class="forgot-password-link" onclick="openModal('forgot')">¿Has olvidado la contraseña?</button>

        <div class="social-login">
            <button class="google-btn">Continuar con Google</button>
            <button class="facebook-btn">Continuar con Facebook</button>
        </div>

        <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>

        <a href="{{ url('/') }}" class="btn volver-btn">Regresar</a>
        </div>
    </div>

    <div id="forgotModal" class="modal-overlay">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal('forgot')">✖</button>
            <h3>Recuperar contraseña</h3>
            <p>Ingresa tu correo o cédula y te enviaremos un código de verificación.</p>
            <form action="{{ route('password.forgot') }}" method="POST">
                @csrf
                <input type="hidden" name="reset_action" value="forgot">
                <input type="text" name="email_or_document" placeholder="Correo o cédula" value="{{ old('email_or_document') }}" required>
                @error('email_or_document')<p class="modal-error">{{ $message }}</p>@enderror
                <button type="submit">Recibir código</button>
            </form>
        </div>
    </div>

    <div id="verifyModal" class="modal-overlay">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal('verify')">✖</button>
            <h3>Verificar código</h3>
            <p>Ingresa el código que te enviamos al correo registrado.</p>
            <form action="{{ route('password.verify') }}" method="POST">
                @csrf
                <input type="hidden" name="reset_action" value="verify">
                <input type="text" name="codigo" placeholder="Código de verificación" required>
                @error('codigo')<p class="modal-error">{{ $message }}</p>@enderror
                <button type="submit">Verificar código</button>
            </form>
        </div>
    </div>

    <div id="resetModal" class="modal-overlay">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal('reset')">✖</button>
            <h3>Nueva contraseña</h3>
            <p>Escribe tu nueva contraseña y confirma para actualizarla.</p>
            <form action="{{ route('password.reset') }}" method="POST">
                @csrf
                <input type="hidden" name="reset_action" value="reset">
                <input type="hidden" name="password_reset_user_id" value="{{ old('password_reset_user_id', session('password_reset_user_id')) }}">
                <input type="hidden" name="password_reset_user_email" value="{{ old('password_reset_user_email', session('password_reset_user_email')) }}">
                <input type="hidden" name="password_reset_verified" value="{{ old('password_reset_verified', session('password_reset_verified') ? '1' : '') }}">
                <input type="password" name="password" placeholder="Contraseña nueva" required>
                @error('password')<p class="modal-error">{{ $message }}</p>@enderror
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                <button type="submit">Actualizar contraseña</button>
            </form>
        </div>
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

        function openModal(modalId) {
            document.getElementById(modalId + 'Modal').classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId + 'Modal').classList.remove('active');
        }

        window.addEventListener('click', function(event) {
            ['forgotModal', 'verifyModal', 'resetModal'].forEach(id => {
                const modal = document.getElementById(id);
                if (modal && event.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('showForgotModal'))
                openModal('forgot');
            @endif
            @if(session('showVerifyModal'))
                openModal('verify');
            @endif
            @if(session('showResetModal'))
                openModal('reset');
            @endif

            const resetAction = '{{ old('reset_action') }}';
            if (resetAction === 'forgot') openModal('forgot');
            if (resetAction === 'verify') openModal('verify');
            if (resetAction === 'reset') openModal('reset');
        });
    </script>
</body>
</html>
