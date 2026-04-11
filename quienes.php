<?php
$jsonFile = "../../json/quienes.json";
$data = json_decode(file_get_contents($jsonFile), true);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data["mision"] = $_POST["mision"];
    $data["vision"] = $_POST["vision"];
    $data["valores"] = array_filter(explode("\n", $_POST["valores"]));

    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $mensaje = "✅ Información actualizada correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar “Quiénes Somos” | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: #f4f7f6;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #2e8b57;
        }

        form {
            max-width: 700px;
            margin: 20px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            color: #333;
        }

        textarea {
            width: 100%;
            height: 100px;
            margin-top: 8px;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            background: linear-gradient(90deg, #2e8b57, #4caf50);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .mensaje {
            text-align: center;
            color: #2e8b57;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>✏️ Editar Página “Quiénes Somos”</h2>

    <?php if (!empty($mensaje)): ?>
        <p class="mensaje"><?= $mensaje ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Misión:</label>
        <textarea name="mision"><?= htmlspecialchars($data["mision"]) ?></textarea>

        <label>Visión:</label>
        <textarea name="vision"><?= htmlspecialchars($data["vision"]) ?></textarea>

        <label>Valores (uno por línea):</label>
        <textarea name="valores"><?= implode("\n", $data["valores"]) ?></textarea>

        <button type="submit">💾 Guardar Cambios</button>
        <a href="/Html/admi/index1.php" style="margin-left: 15px; text-decoration: none; color: #4caf50;">Regresar </a>

    </form>
</body>

</html>