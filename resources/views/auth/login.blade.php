@extends('layouts.adopter.app')

@section('title', 'Login | SDAANIM')

@section('styles')
    <style>
        .login-container {
            background: #ffffff;
            padding: 35px 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 380px;
            margin: 40px auto;
            text-align: center;
            box-sizing: border-box;
        }
        .login-container h2 {
            margin-bottom: 25px;
            color: #2d7d46;
            font-size: 1.8rem;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .login-container input {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        .login-container input:focus {
            border-color: #2d7d46;
            outline: none;
        }
        .password-field { position: relative; width: 100%; box-sizing: border-box; }
        .eye-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0;
            display: flex;
            align-items: center;
        }
        .btn {
            background: #2d7d46;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
            box-sizing: border-box;
        }
        .btn:hover { background: #246338; }
        .forgot-password-link {
            background: none;
            border: none;
            color: #666;
            font-size: 0.85em;
            cursor: pointer;
            margin-top: 5px;
            text-decoration: underline;
        }
        .social-login {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .google-btn, .facebook-btn {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            box-sizing: border-box;
        }
        .facebook-btn { background: #1877f2; color: white; border: none; }
        .error-msg { color: #ef4444; font-size: 0.75em; text-align: left; margin-top: -10px; font-weight: 500; }
    </style>
@endsection

@section('content')
    <div class="login-container">
        <h2>Inicia Sesión</h2>

        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9em;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input
                type="text"
                inputmode="numeric"
                pattern="[0-9]*"
                name="Usu_documento"
                placeholder="Número de Documento"
                value="{{ old('Usu_documento') }}"
                required
                autofocus
                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
            />
            @error('Usu_documento')
                <p class="error-msg">{{ $message }}</p>
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
                <p class="error-msg">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn">Ingresar</button>
        </form>

        <button type="button" class="forgot-password-link" onclick="openModal('forgot')">¿Has olvidado la contraseña?</button>

        <div class="social-login">
            <button class="google-btn">Continuar con Google</button>
            <button class="facebook-btn">Continuar con Facebook</button>
        </div>

        <p style="margin-top:20px; font-size:0.85em;">¿No tienes cuenta? <a href="{{ route('register') }}" style="color:#2d7d46; font-weight:bold;">Regístrate</a></p>
    </div>

    <!-- Modales de Recuperación -->
    <div id="forgotModal" class="form-modal-overlay" onclick="closeModalOutside(event, 'forgot')">
        <div class="form-modal-card" style="max-width: 380px; text-align: center;">
            <button class="form-modal-close" onclick="closeModal('forgot')">✖</button>
            <h3>Recuperar contraseña</h3>
            <p style="margin-bottom:15px; font-size:0.9em;">Ingresa tu correo o cédula y te enviaremos un código.</p>
            <form action="{{ route('password.forgot') }}" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
                @csrf
                <input type="hidden" name="reset_action" value="forgot">
                <input type="text" name="email_or_document" placeholder="Correo o cédula" style="padding:10px; border-radius:8px; border:1px solid #ddd; width:100%; box-sizing:border-box;" required>
                <button type="submit" class="btn">Recibir código</button>
            </form>
        </div>
    </div>
    
    <div id="verifyModal" class="form-modal-overlay @if(session('showVerifyModal')) active @endif" onclick="closeModalOutside(event, 'verify')">
        <div class="form-modal-card" style="max-width: 380px; text-align: center;">
            <button class="form-modal-close" onclick="closeModal('verify')">✖</button>
            <h3>Verificar código</h3>
            <form action="{{ route('password.verify') }}" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
                @csrf
                <input type="hidden" name="reset_action" value="verify">
                <input type="text" name="codigo" placeholder="Código de 6 dígitos" style="padding:10px; border-radius:8px; border:1px solid #ddd; width:100%; box-sizing:border-box;" required>
                <button type="submit" class="btn">Verificar</button>
            </form>
        </div>
    </div>

    <div id="resetModal" class="form-modal-overlay @if(session('showResetModal')) active @endif" onclick="closeModalOutside(event, 'reset')">
        <div class="form-modal-card" style="max-width: 380px; text-align: center;">
            <button class="form-modal-close" onclick="closeModal('reset')">✖</button>
            <h3>Nueva contraseña</h3>
            <form action="{{ route('password.reset') }}" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
                @csrf
                <input type="hidden" name="reset_action" value="reset">
                <input type="hidden" name="password_reset_user_id" value="{{ old('password_reset_user_id', session('password_reset_user_id')) }}">
                <input type="hidden" name="password_reset_user_email" value="{{ old('password_reset_user_email', session('password_reset_user_email')) }}">
                <input type="hidden" name="password_reset_verified" value="{{ old('password_reset_verified', session('password_reset_verified') ? '1' : '') }}">
                <input type="password" name="password" placeholder="Contraseña nueva" style="padding:10px; border-radius:8px; border:1px solid #ddd; width:100%; box-sizing:border-box;" required>
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" style="padding:10px; border-radius:8px; border:1px solid #ddd; width:100%; box-sizing:border-box;" required>
                <button type="submit" class="btn">Actualizar</button>
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
            const m = document.getElementById(modalId + 'Modal');
            if(m) m.classList.add('active');
        }

        function closeModal(modalId) {
            const m = document.getElementById(modalId + 'Modal');
            if(m) m.classList.remove('active');
        }

        function closeModalOutside(event, modalId) {
            const modal = document.getElementById(modalId + 'Modal');
            if (event.target === modal) closeModal(modalId);
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('showForgotModal')) openModal('forgot'); @endif
            @if(session('showVerifyModal')) openModal('verify'); @endif
            @if(session('showResetModal')) openModal('reset'); @endif
        });
    </script>
@endsection
