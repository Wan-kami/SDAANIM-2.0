<?php
session_start();
include("../../Php/conexion.php");

// Verificar que sea administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') {
    echo "Acceso solo para administradores";
    exit();
}

/* =========================================
   SI SE PRESIONA PAGADO O CANCELAR
========================================= */

if (isset($_GET['accion']) && isset($_GET['id'])) {

    $id_reserva = $_GET['id'];

    // MARCAR COMO PAGADO
    if ($_GET['accion'] == "pagado") {

        $sql = "UPDATE reservas_productos 
                SET re_estado='Pagado' 
                WHERE re_sid='$id_reserva'";

        $conn->query($sql);
    }

    // CANCELAR RESERVA
    if ($_GET['accion'] == "cancelar") {

        // 1️⃣ Buscar producto de esa reserva
        $buscar = "SELECT prod_id FROM reservas_productos 
                   WHERE re_id='$id_reserva'";

        $resultado = $conn->query($buscar);
        $fila = $resultado->fetch_assoc();
        $prod_id = $fila['prod_id'];

        // 2️⃣ Devolver 1 al stock
        $conn->query("UPDATE productos 
                      SET prod_cantidad = prod_cantidad + 1 
                      WHERE prod_id='$prod_id'");

        // 3️⃣ Cambiar estado a cancelado
        $conn->query("UPDATE reservas_productos 
                      SET re_estado='Cancelado' 
                      WHERE re_id='$id_reserva'");
    }

    // Recargar página
    header("Location: reservas_admin.php");
    exit();
}

/* =========================================
   MOSTRAR SOLO RESERVAS PENDIENTES
========================================= */

$sql = "SELECT r.re_id, r.re_fecha, 
               u.Usu_nombre, u.Usu_documento,
               p.prod_nombre, p.prod_precio
        FROM reservas_productos r
        INNER JOIN usuario u ON r.usuario_id = u.Usu_documento
        INNER JOIN productos p ON r.prod_id = p.prod_id
        WHERE r.re_estado='Pendiente'
        ORDER BY r.re_fecha DESC";

$resultado = $conn->query($sql);
?>

<h2>Reservas Pendientes</h2>

<table border="1" cellpadding="8">
<tr>
    <th>Nombre</th>
    <th>Documento</th>
    <th>Producto</th>
    <th>Valor a pagar</th>
    <th>Fecha</th>
    <th>Acciones</th>
</tr>

<?php
if ($resultado->num_rows > 0) {

    while ($row = $resultado->fetch_assoc()) {

        echo "<tr>
            <td>{$row['Usu_nombre']}</td>
            <td>{$row['Usu_documento']}</td>
            <td>{$row['prod_nombre']}</td>
            <td>$ {$row['prod_precio']}</td>
            <td>{$row['re_fecha']}</td>
            <td>
                <a href='reservas_admin.php?accion=pagado&id={$row['re_id']}'>
                    Pagado
                </a>
                |
                <a href='reservas_admin.php?accion=cancelar&id={$row['re_id']}'
                   onclick=\"return confirm('¿Cancelar reserva?')\">
                    Cancelar
                </a>
            </td>
        </tr>";
    }

} else {
    echo "<tr><td colspan='6'>No hay reservas pendientes.</td></tr>";
}
?>

</table>