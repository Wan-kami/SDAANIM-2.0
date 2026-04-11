<?php
include '../../Php/conexion.php'; // conexión a la BD

// Seleccionamos solo los usuarios con rol 'adoptante'
$sql = "SELECT * FROM usuario WHERE Usu_Rol = 'adoptante' ORDER BY Usu_email DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Adoptantes Registrados</title>
    <style>
        body {
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }

        a {
            text-decoration: none;
        }

        .header {
            background: linear-gradient(90deg, #2e8b57, #4caf50);
            color: white;
            padding: 12px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .header h2 {
            margin: 0;
            font-family: 'Pacifico', cursive;
            font-size: 1.5em;
            color: black;
        }

        table {
            width: 95%;
            border-collapse: collapse;
            margin: 20px auto;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #6f9f84ff;
            color: #000000ff;
            padding: 12px 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f8f8ff;
        }

        tr:hover {
            background-color: #f1f0ff;
            transition: 0.3s ease;
        }

        .fancy-btn {
            font-size: 16px;
            padding: 12px 30px;
            margin-left: 2.5%;
            background-color: #d8dde0ff;
            color: black;
            cursor: pointer;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .fancy-btn:hover {
            background-color: #6f9f84ff;
            color: white;
            transition: background-color 0.3s ease;
        }

        .no-users {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #666;
        }
    </style>
</head>

<body>
    <header class="header">
        <h2>Veterinarios Registrados</h2>
    </header>
    <br>
    <a href="../admi/index1.php" class="fancy-btn"><span>← Volver</span></a>

    <?php if ($resultado->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($fila['Usu_documento']) ?></td>
                    <td><?= htmlspecialchars($fila['Usu_nombre']) ?></td>
                    <td><?= htmlspecialchars($fila['Usu_email']) ?></td>
                    <td><?= htmlspecialchars($fila['Usu_telefono']) ?></td>
                    <td><?= htmlspecialchars($fila['Usu_direccion']) ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="no-users">No hay adoptantes registrados.</p>
    <?php } ?>
</body>

</html>