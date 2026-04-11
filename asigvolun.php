<?php
include '../../php/Conexion.php';

if (!isset($_GET['Soli_id'])) {
    echo "Error: solicitud no encontrada.";
    exit();
}

$sol_id = $_GET['Soli_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar voluntario</title>
    <link rel="stylesheet" href="../../css/admin.css">

</head>

<body>
    <header class="header">
        <h2>Asignar voluntarios</h2>
    </header>

    <br>
    <a href="../admi/index1.php" class="fancy-btn"><span>← Volver</span></a>

    <div class="contenedor">

        <form action="../../Php/asig.php" method="POST">
            <input type="hidden" name="Soli_id" value="<?= $sol_id ?>">

            <label for="vol_id">Seleccionar voluntario:</label>
            <select name="vol_id" id="vol_id" required>
                <option value="">Seleccione...</option>

                <?php
                // CONSULTAR VOLUNTARIOS
                $query = "SELECT Usu_documento, Usu_nombre FROM usuario WHERE Usu_Rol = 'Voluntario'";
                $voluntarios = $conn->query($query);

                if ($voluntarios->num_rows > 0) {
                    while ($v = $voluntarios->fetch_assoc()) {
                        echo "<option value='{$v['Usu_documento']}'>{$v['Usu_nombre']}</option>";
                    }
                } else {
                    echo "<option disabled>No hay voluntarios registrados</option>";
                }
                ?>
            </select>

            <button type="submit">Asignar</button>
    </div>
    </form>
    <footer>
        <p>© 2025 Esperanza Animal BQ - Panel de Administración</p>
    </footer>
    </div>

</body>

</html>