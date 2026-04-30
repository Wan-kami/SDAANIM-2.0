@extends('layouts.adopter.app')

@section('title', 'Registro | SDAANIM')

@section('styles')
    <style>
        .register-container {
            background: #ffffff;
            padding: 35px 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 580px;
            margin: 40px auto;
            text-align: center;
            box-sizing: border-box;
        }
        .register-container h2 {
            margin-bottom: 25px;
            color: #2d7d46;
            font-size: 1.8rem;
            /* Se hereda Merriweather del layout */
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            text-align: left;
        }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group label { font-size: 0.85em; font-weight: bold; color: #444; }
        .form-group input {
            padding: 10px 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            box-sizing: border-box;
            width: 100%;
        }
        .form-group input:focus {
            border-color: #2d7d46;
            outline: none;
        }
        .error-msg { color: #ef4444; font-size: 0.75em; margin-top: 2px; font-weight: 500; }
        .full-width { grid-column: span 2; }
        .password-field { position: relative; width: 100%; box-sizing: border-box; }
        .eye-toggle {
            position: absolute;
            right: 10px;
            top: 28px;
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
            font-size: 1.1rem;
        }
        .pwd-info {
            font-size: 0.75em;
            color: #64748b;
            margin-top: 5px;
            line-height: 1.4;
            background: #f8fafc;
            padding: 8px;
            border-radius: 6px;
            border-left: 3px solid #cbd5e1;
        }
        .btn {
            background: #2d7d46;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn:hover { background: #246338; }
        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
        }
    </style>
@endsection

@section('content')
    <div class="register-container">
        <h2>Únete a nosotros</h2>

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9em;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Documento</label>
                    <input type="text" name="Usu_documento" value="{{ old('Usu_documento') }}" placeholder="Sin puntos ni letras" required autofocus />
                    @error('Usu_documento') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej: Juan Pérez" required />
                    @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group full-width">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com" required />
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="Usu_telefono" value="{{ old('Usu_telefono') }}" required />
                    @error('Usu_telefono') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="Usu_direccion" value="{{ old('Usu_direccion') }}" required />
                    @error('Usu_direccion') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group password-field">
                    <label>Contraseña</label>
                    <input type="password" name="password" id="register-password" required />
                    <button type="button" onclick="togglePasswordVisibility('register-password', this)" class="eye-toggle">👁️</button>
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group password-field">
                    <label>Confirmar</label>
                    <input type="password" name="password_confirmation" id="register-password_conf" required />
                    <button type="button" onclick="togglePasswordVisibility('register-password_conf', this)" class="eye-toggle">👁️</button>
                </div>
                
                <div class="full-width">
                    <div class="pwd-info">
                        <strong>Requisitos:</strong> Mínimo 8 caracteres, al menos 5 números, 1 mayúscula, 1 minúscula y 1 carácter especial (@$!%*?&-_#).
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px; text-align: left;">
                <label style="font-size: 0.8em; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="accept_data_policy" required style="width: 16px; height: 16px; margin: 0;">
                    <span>Acepto la <a href="javascript:void(0)" onclick="abrirModalPolitica()" style="color:#2d7d46; text-decoration:underline;">Política de Tratamiento de Datos</a></span>
                </label>
            </div>

            <button type="submit" class="btn">Registrarse</button>
        </form>

        <p style="margin-top:20px; font-size:0.85em;">¿Ya tienes cuenta? <a href="{{ route('login') }}" style="color:#2d7d46; font-weight:bold;">Inicia sesión</a></p>
    </div>

    <!-- Modal de Verificación de Código -->
    <div id="verifyModal" class="form-modal-overlay @if(session('mostrar_modal')) active @endif" style="z-index: 10001;">
        <div class="form-modal-card" style="max-width: 400px; text-align: center; padding: 40px 30px;">
            <div style="font-size: 3em; margin-bottom: 10px;">📩</div>
            <h3 style="color: #2d7d46; margin-bottom: 15px;">Verifica tu Email</h3>
            <p style="color: #64748b; margin-bottom: 25px; font-size: 0.95em;">Hemos enviado un código a tu correo. Por favor, ingrésalo para completar tu registro.</p>
            
            <form action="{{ route('verify.code') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                @csrf
                <input type="number" name="codigo" placeholder="Introduce el código de 6 dígitos" 
                    style="padding: 12px; border-radius: 10px; border: 1.5px solid #e2e8f0; font-size: 1.1em; text-align: center; width: 100%; box-sizing: border-box;" required>
                <button type="submit" class="btn" style="margin-top: 5px;">Verificar Cuenta</button>
            </form>
            
            <p style="margin-top: 20px; font-size: 0.85em; color: #94a3b8;">¿No recibiste el código? Revisa tu carpeta de spam.</p>
        </div>
    </div>

    @include('partials.data_policy_modal')

    <script>
        function togglePasswordVisibility(id, btn) {
            const input = document.getElementById(id);
            if(input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
            } else {
                input.type = 'password';
                btn.textContent = '👁️';
            }
        }
    </script>
@endsection