<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Verificación</title>
    <link rel="stylesheet" href="{{ asset('css/shared/email.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verificación de Registro</h1>
            <p>Esperanza Animal BQ</p>
        </div>
        <div class="content">
            <div class="greeting">
                Hola <strong>{{ $nombre }}</strong>,
            </div>
            <p style="margin-top: 15px; font-size: 16px; color: #444; line-height: 1.7;">
                Gracias por unirte a <strong>Esperanza Animal BQ</strong>. Para continuar con la creación de tu cuenta, ingresa el siguiente código en el formulario de registro.
            </p>
            <div class="credentials" style="margin-top: 20px; padding: 20px; background: #f0fdf4; border-color: #34d399;">
                <div class="credentials-label">Tu usuario</div>
                <div class="credential-value" style="margin-bottom: 12px;">{{ $documento }}</div>
                <div class="credentials-label">Código de verificación</div>
                <div class="credential-value" style="font-size: 22px; letter-spacing: 2px;">{{ $codigo }}</div>
            </div>
            <p style="margin-top: 20px; font-size: 14px; color: #555;">
                Si no solicitaste este registro, ignora este correo. Este código expirará en unos minutos.
            </p>
            <center>
                <a href="{{ url('/registrar') }}" class="btn">Continuar registro</a>
            </center>
            <div style="background-color: #e8f5e9; padding: 15px; border-radius: 8px; margin-top: 25px; color: #2d7d46; font-size: 14px;">
                Tu documento será tu usuario para ingresar al sistema.
            </div>
        </div>
        <div class="footer">
            © {{ date('Y') }} Esperanza Animal BQ. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
