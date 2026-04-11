<?php
include '../../Php/Conexion.php';

$id = "";
$nombre = "";
$categoria = "";
$precio = "";
$cantidad = "";
$imagenActual = "";

// SI VIENE ID → ES EDICIÓN
if (isset($_GET['id'])) {

  $id = $_GET['id'];

  $sql = "SELECT * FROM productos WHERE prod_id = $id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $producto = $result->fetch_assoc();

    $nombre = $producto['prod_nombre'];
    $categoria = $producto['prod_categoria'];
    $precio = $producto['prod_precio'];
    $cantidad = $producto['prod_cantidad'];
    $imagenActual = $producto['prod_imagen'];
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Panel Admin - Gestionar Adopciones</title>
  <link rel="stylesheet" href="/css/style.css" />
  <link rel="stylesheet" href="/css/index.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap"
    rel="stylesheet" />

  <style>
    body {
      background-color: #f7f7f7;
      font-family: "Arial", sans-serif;
    }

    .volver {
      color: #4caf50;
      text-decoration: underline;
    }

    .admin-container {
      width: 90%;
      margin: 30px auto;
    }

    .admin-form {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .admin-form h2 {
      color: #4caf50;
      margin-bottom: 10px;
    }

    .admin-form label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }

    .admin-form input[type="text"],
    .admin-form textarea,
    .admin-form select,
    .admin-form input[type="file"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-top: 5px;
    }

    .admin-form button {
      background-color: #4caf50;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 15px;
    }

    .admin-form button:hover {
      background-color: #45a049;
    }

    /* Grilla de mascotas */
    .adopta-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 20px;
    }

    .adopta-card {
      background: white;
      border-radius: 10px;
      padding: 10px;
      text-align: center;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .adopta-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px;
    }

    .adopta-card h3 {
      color: #333;
      margin-top: 10px;
    }

    .adopta-card p {
      color: #555;
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
  </style>
</head>

<body>
  <header>
    <h1>Panel de Adopciones</h1>
  </header>
  <br />
  <a href="productos.php" class="fancy-btn"><span>← Volver</span></a>

  <main class="admin-container">

    <section class="admin-form">

      <h2><?php echo $id ? "Editar Producto" : "Agregar Producto"; ?></h2>
      <form action="../../Php/Rprod.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label>Nombre del producto:</label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>" required>

        <label>Categoria:</label>
        <select name="categoria" required>
          <option value="">Seleccionar</option>
          <option value="Comida" <?php if ($categoria == "Comida") echo "selected"; ?>>Comida</option>
          <option value="Juguetes" <?php if ($categoria == "Juguetes") echo "selected"; ?>>Juguetes</option>
          <option value="Accesorios" <?php if ($categoria == "Accesorios") echo "selected"; ?>>Accesorios</option>
        </select>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" value="<?php echo $precio; ?>" required>

        <label>Cantidad:</label>
        <input type="number" name="cantidad" value="<?php echo $cantidad; ?>" required>

        <label>Imagen:</label>
        <input type="file" name="imagen">

        <?php if ($imagenActual) { ?>
          <p>Imagen actual:</p>
          <img src="../../img/<?php echo $imagenActual; ?>" width="120">
        <?php } ?>

        <button type="submit" name="submit">Guardar</button>

      </form>
    </section>
  </main>

  <footer id="contacto">
    <p>© 2025 Esperanza Animal BQ - Panel de Administración</p>
    <p>© 2025 AdoptaYa - Todos los derechos reservados</p>
  </footer>
</body>

</html>