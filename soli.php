<?php
include '../../PHP/Conexion.php';

// Traer solicitudes pendientes PERO también con info de seguimiento si existe
$sql = "
    SELECT s.*, seg.Segui_fecha_visita, seg.Segui_descripcion, seg.Segui_estado AS Segui_estado
    FROM solicitud_adopcion s
    LEFT JOIN seguimiento_adopcion seg ON s.Segui_id = seg.Segui_id
    WHERE s.Soli_estado = 'Pendiente' OR s.Soli_estado = 'En seguimiento'
";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopciones Pendientes</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>

<body>
    <header class="header">
        <h2>Adopciones enviadas</h2>
    </header>

    <br>
    <a href="../admi/index1.php" class="fancy-btn"><span>← Volver</span></a>

    <main class="main-content">
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Animal</th>
                <th>Fecha Solicitud</th>
                <th>Motivo</th>
                <th>Otras Mascotas</th>
                <th>Vivienda</th>
                <th>Comentario</th>
                <th>Seguimiento</th>
                <th>Acción</th>
            </tr>

            <?php while ($row = $res->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['Soli_id'] ?></td>
                    <td><?= $row['Usu_documento'] ?></td>
                    <td><?= $row['Anim_id'] ?></td>
                    <td><?= $row['Soli_fecha'] ?></td>
                    <td><?= $row['Soli_motivo'] ?></td>
                    <td><?= $row['Soli_otras_mascotas'] ?></td>
                    <td><?= $row['Soli_tipo_vivienda'] ?></td>
                    <td><?= $row['Soli_comentarios'] ?></td>

                    <td>
                        <?php if ($row['Segui_estado'] == "Realizada") { ?>
                            <b>Fecha visita:</b> <?= $row['Segui_fecha_visita'] ?><br>
                            <b>Informe:</b> <?= $row['Segui_descripcion'] ?>
                        <?php } else { ?>
                            <i>Aún no completado</i>
                        <?php } ?>
                    </td>

                    <td>
                        <?php 
                        // Si NO tiene seguimiento → asignar voluntario
                        if (empty($row['Segui_estado'])) { 
                        ?>
                            <a href="../admi/asigvolun.php?Soli_id=<?= $row['Soli_id'] ?>" 
                               class="btn-asignar">
                               Asignar voluntario
                            </a>

                        <?php 
                        // Si YA tiene seguimiento finalizado → aprobar o rechazar
                        } elseif ($row['Segui_estado'] == "Realizada") { 
                        ?>
                            <a href="../../Php/aprobar.php?Soli_id=<?= $row['Soli_id'] ?>" 
                               class="btn-ok">
                               Aprobar
                            </a>
                            <a href="../../Php/rechazar.php?Soli_id=<?= $row['Soli_id'] ?>" 
                               class="btn-cancel">
                               Rechazar
                            </a>
                        <?php 
                        // Si está asignado pero NO completado
                        } else { 
                        ?>
                            <span class="badge">En seguimiento…</span>
                        <?php } ?>
                    </td>

                </tr>
            <?php } ?>
        </table>
    </main>

    <footer>
        <p>© 2025 Esperanza Animal BQ - Panel de Administración</p>
    </footer>
</body>

</html>
