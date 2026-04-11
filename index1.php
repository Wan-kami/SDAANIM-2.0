<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador | Esperanza Animal BQ</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    <style>
        /* -----------------------------
           ESTILOS GENERALES
        ----------------------------- */

        body {
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        /* -----------------------------
           HEADER ADMIN
        ----------------------------- */

        .admin-header {
            background: linear-gradient(90deg, #2e8b57, #4caf50);
            color: white;
            padding: 12px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .admin-header .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-header img {
            height: 45px;
        }

        .admin-header h2 {
            font-family: 'Pacifico', cursive;
            font-size: 1.8em;
            margin: 0;
            color: black;
        }

        .admin-header a {
            color: #fff;
            font-weight: bold;
            border-bottom: 2px solid transparent;
            transition: 0.3s;
        }

        .admin-header a:hover {
            border-bottom: 2px solid white;
        }

        /* -----------------------------
           BOTÓN NOTIFICACIONES
        ----------------------------- */

        .notif-toggle {
            background-color: white;
            color: #2e8b57;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .notif-toggle:hover {
            background-color: #f0f0f0;
        }

        /* -----------------------------
           BARRA LATERAL DERECHA
        ----------------------------- */

        .notif-sidebar {
            position: fixed;
            top: 0;
            right: -320px;
            /* Oculta inicialmente */
            width: 300px;
            height: 100%;
            background-color: #ffffff;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
            transition: right 0.4s ease;
            z-index: 1000;
            padding: 20px;
        }

        .notif-sidebar.active {
            right: 0;
        }

        .notif-sidebar h3 {
            color: #2e8b57;
            text-align: center;
            margin-bottom: 20px;
        }

        .notif-sidebar a {
            display: block;
            padding: 12px;
            color: #333;
            border-bottom: 1px solid #eee;
            transition: 0.3s;
            border-radius: 5px;
        }

        .notif-sidebar a:hover {
            background-color: #e9f7ef;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #2e8b57;
        }

        /* -----------------------------
           PANEL DE SECCIONES
        ----------------------------- */

        main {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .admin-sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
        }

        .admin-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-align: center;
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .admin-card h3 {
            color: #2e8b57;
            font-size: 1.4em;
            margin-bottom: 10px;
        }

        .admin-card p {
            color: #555;
            font-size: 0.95em;
            margin-bottom: 20px;
        }

        .admin-card a {
            display: inline-block;
            background: linear-gradient(90deg, #2e8b57, #4caf50);
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            transition: 0.3s;
            font-weight: bold;
        }

        .admin-card a:hover {
            background: linear-gradient(90deg, #256d45, #3e9e42);
        }

        /* ÍCONOS EN LAS TARJETAS */

        .admin-card .icon {
            font-size: 40px;
            color: #4caf50;
            margin-bottom: 10px;
        }

        /* -----------------------------
           FOOTER
        ----------------------------- */

        footer {
            background: #2e8b57;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
            font-size: 0.9em;
        }

        /* -----------------------------
           RESPONSIVE
        ----------------------------- */

        @media (max-width: 600px) {
            .admin-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .admin-card {
                padding: 20px 15px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="admin-header">
        <div class="logo">
            <img src="../../img/a.png" alt="Logo">
            <h2>Panel Administrador</h2>
        </div>

        <div>
            <button class="notif-toggle" onclick="toggleSidebar()">🔔
                Notificaciones</button>
        </div>
        <div class="search-container">
            <nav class="nav-right">
                <?php if (isset($_SESSION['nombre'])): ?>
                    <span class="usuario-nombre"> <?php echo $_SESSION['nombre']; ?></span>

                <?php else: ?>
                    <button onclick="window.location.href='../adopt/login.php'" class="filtro">Iniciar Sesión</button>
                    <button onclick="window.location.href='../adopt/registro.php'" class="filtro">Registrarse</button>
                <?php endif; ?>
            </nav>
            <div class="usuario"> 
                <a href="p-adop.php"><img src="../../img/usuario.png" alt="Usuario" id="usuario-icon"></a>
            </div>
        </div>

    </header>

    <!-- BARRA LATERAL DE NOTIFICACIONES -->
    <div id="notifSidebar" class="notif-sidebar">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Notificaciones</h3>
        <a href="../admi/ins_volun.php">📋 Nuevos voluntarios postulados</a>
        <a href="../admi/ins_adopt.php">🐾 Adoptantes registrados</a>
        <a href="../admi/ins_vete.php">⚕️ Veterinarios postulados</a>
         <a href="../admi/soli.php">Adopciones enviadas</a>
    </div>

    <!-- SECCIONES DEL PANEL -->
    <main>
        <section class="admin-sections">

            <div class="admin-card">
                <div class="icon">⚕️</div>
                <h3>Veterinarios</h3>
                <p>Agenda citas, revisa solicitudes y coordina las
                    atenciones médicas de las mascotas.</p>
                <a href="asig_cita.php">Agendar Citas</a>
            </div>

            <div class="admin-card">
                <div class="icon">🐶</div>
                <h3>Adopciones</h3>
                <p>Gestiona animales en adopción y agrega nuevas fotos o
                    perfiles para adopción.</p>
                <a href="adopta1.php">Agregar Animal</a>
            </div>
            <div class="admin-card">
                <div class="icon">🛒</div>
                <h3>Productos</h3>
                <p>Gestiona los productos disponibles y administra su información.</p>
                <a href="productos.php">Gestionar Productos</a>
            </div>

            <div class="admin-card">
                <div class="icon">📊</div>
                <h3>Nuestra Historia</h3>
                <p>Editar la historia, valores, misión o visión del
                    refugion. Asi mantener la pagina lo más actualizada
                    posible.</p>
                <a href="../admi/quienes.php">Editar Historia</a>
            </div>

        </section>
    </main>

    <footer>
        <p>© 2025 Esperanza Animal BQ | Panel Administrador</p>
    </footer>

    <script>
        // Función para abrir/cerrar la barra lateral
        function toggleSidebar() {
            const sidebar = document.getElementById("notifSidebar");
            sidebar.classList.toggle("active");
        }
    </script>

</body>

</html>