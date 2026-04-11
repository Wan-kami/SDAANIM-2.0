<?php
include '../../PHP/Conexion.php';

// Traer solo los voluntarios
$sql = "SELECT * FROM inscripcion WHERE ins_tipo_rol = 'voluntario'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripciones Voluntarios</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>

<header class="header">
        <h2>Voluntarios Registrados</h2>
        
</header>
<br>
<a href="../admi/index1.php" class="fancy-btn"><span>← Volver</span></a>

<main class="main-content">
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Tipo de ayuda</th>
                <th>Comentarios</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['ins_id'] ?></td>
                <td><?= $row['ins_documento'] ?></td>
                <td><?= $row['ins_nombre'] ?></td>
                <td><?= $row['ins_email'] ?></td>
                <td><?= $row['ins_telefono'] ?></td>
                <td><?= $row['ins_direccion'] ?></td>
                <td><?= $row['ins_tipo_ayuda'] ?></td>
                <td><?= $row['ins_comentario'] ?></td>
                <td><?= $row['ins_estado'] ?></td>
                <td>
                    <?php if ($row['ins_estado'] == 'Pendiente') { ?>
                        <form action="../../PHP/procesar_inscripcion.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['ins_id'] ?>">
                            <input type="hidden" name="accion" value="aceptar">
                            <button type="submit">Aceptar</button>
                        </form>
                        <form action="../../PHP/procesar_inscripcion.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['ins_id'] ?>">
                            <input type="hidden" name="accion" value="rechazar">
                            <button type="submit">Rechazar</button>
                        </form>
                    <?php } else { ?>
                        <span><?= $row['ins_estado'] ?></span>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</main>

<footer>
    <p>© 2025 Esperanza Animal BQ - Panel de Administración</p>
</footer>

</body>
</html>
