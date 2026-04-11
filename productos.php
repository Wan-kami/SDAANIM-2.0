<?php
include '../../Php/Conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Adopción de Mascotas</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style>
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

        /* ---------------- HEADER ---------------- */
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
            background: none;
            border: none;
            font-size: 1.2em;
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            color: #888;
        }

        /* ---------------- MAIN ---------------- */
        main {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            color: #000000;
            text-align: center;
            margin-bottom: 20px;
        }

        .adopta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
        }

        .adopta-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-align: center;
        }

        .adopta-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .adopta-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .adopta-card h3 {
            color: #2e8b57;
            margin: 10px 0 5px;
        }

        .adopta-card p {
            font-size: 0.9em;
            color: #555;
            margin-bottom: 15px;
        }

        .adopta-card button {
            background: linear-gradient(90deg, #2e8b57, #4caf50);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
            margin: 5px;
        }

        .adopta-card button:hover {
            background: linear-gradient(90deg, #256d45, #3e9e42);
        }

        /* Tarjeta para agregar nuevo */
        .add-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 2px dashed #2e8b57;
            background-color: #e9f7ef;
            cursor: pointer;
            transition: 0.3s;
        }

        .add-card:hover {
            background-color: #dff3e8;
            transform: scale(1.03);
        }

        .add-card img {
            width: 80px;
            height: 80px;
            opacity: 0.7;
            margin-bottom: 10px;
        }

        .add-card h3 {
            color: #2e8b57;
            font-weight: bold;
        }

        footer {
            background: #2e8b57;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
        }

        @media (max-width: 600px) {
            .admin-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <header class="admin-header">
        <div class="logo">
            <img src="../../img/a.png" alt="Logo">
            <h2>Panel Administrador</h2>
        </div>
        <nav>
            <a href="../admi/index1.html">Inicio</a>
            <a href="/Html/admi/quienes.php">Quiénes somos</a>
            <a href="../adopt/contacto.html">Contacto</a>
        </nav>

        <div>
            <button class="notif-toggle" onclick="toggleSidebar()">🔔 Notificaciones</button>
        </div>
    </header>

    <!-- BARRA LATERAL DE NOTIFICACIONES -->
    <div id="notifSidebar" class="notif-sidebar">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Notificaciones</h3>
        <a href="../admin/voluntarios.html">📋 Nuevos voluntarios postulados</a>
        <a href="../admin/adoptantes.html">🐾 Adoptantes registrados</a>
        <a href="../admin/veterinarios.html">⚕️ Veterinarios postulados</a>
        <a href="../admin/reportes.html">📢 Reportes recientes</a>
    </div>

    </header>

    <main>
        <a href="../admi/index1.php" class="fancy-btn"><span>← Volver</span></a>
        <h2>Gestión productos para mascotas</h2>
        <p style="text-align:center;">Administra los productos o accesarios paralas mascotas</p>

        <div class="adopta-grid">
            <?php
            $sql = "SELECT * FROM productos ORDER BY Prod_id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($producto = $result->fetch_assoc()) {
                    // Si el campo se llama Anim_foto (como en tu registro)
                    $imagen = "../../img/" . $producto['prod_imagen'];

                    echo "
                        <div class='adopta-card'>
                            <img src='$imagen' alt='{$producto['prod_nombre']}'>
                            <h3>{$producto['prod_nombre']}</h3>
                            <p>Categoria: {$producto['prod_categoria']}</p>
                            <p>Precio: {$producto['prod_precio']}</p>
                            <p>Cantidad: {$producto['prod_cantidad']}</p>
                            <button onclick=\"window.location.href='Fprod.php?id={$producto['prod_id']}'\">Editar</button>
                        </div>
                        ";
                }
            } else {
                echo "<p style='text-align:center;'>No hay productos registrados aún 🐾</p>";
            }
            ?>


            <!-- Tarjeta para agregar -->
            <div class="adopta-card add-card" onclick="window.location.href='Fprod.php'">
                <img src="/img/agregar.png" alt="Agregar nuevo">
                <h3>Agregar nuevo producto</h3>
            </div>
        </div>
    </main>

    <footer>
        <p>📞 Contáctanos: contacto@adoptaya.com | 📍 Barranquilla, Colombia</p>
        <p>© 2025 AdoptaYa - Todos los derechos reservados</p>
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