<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .status-box {
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
        }
        .status-aprobada {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
        .status-rechazada {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        .credentials {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
            background-color: #f1f1f1;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white !important;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Esperanza Animal BQ</h1>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $name }}</strong>,</p>
            
            <p>Te informamos sobre el estado de tu solicitud para unirte como <strong>{{ $role }}</strong> en nuestra fundación.</p>

            <div class="status-box {{ $status === 'Aprobada' ? 'status-aprobada' : 'status-rechazada' }}">
                Tu solicitud ha sido: {{ strtoupper($status) }}
            </div>

            @if($status === 'Aprobada')
                <p>¡Estamos muy emocionados de tenerte con nosotros! Has sido aceptado oficialmente. Tu ayuda será invaluable para nuestros peluditos.</p>
                
                @if($password)
                <div class="credentials">
                    <p>Hemos creado una cuenta para que puedas acceder a nuestra plataforma:</p>
                    <p><strong>Email:</strong> (Usa el correo donde recibiste este mensaje)</p>
                    <p><strong>Contraseña Temporal:</strong> <code>{{ $password }}</code></p>
                    <p style="font-size: 13px; color: #666;">Te recomendamos cambiar tu contraseña una vez ingreses a tu perfil.</p>
                </div>
                @endif

                <center>
                    <a href="{{ url('/login') }}" class="btn">Acceder al Panel</a>
                </center>
            @else
                <p>Lamentablemente, en esta ocasión no hemos podido aprobar tu solicitud. Agradecemos mucho tu interés y te animamos a seguir apoyando la causa animal de otras formas.</p>
            @endif

            <p>Atentamente,<br>El equipo de Esperanza Animal BQ 🐾</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Esperanza Animal BQ. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
