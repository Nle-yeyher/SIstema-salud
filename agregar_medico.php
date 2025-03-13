<?php
include 'conexion.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidad = $_POST['especialidad'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Encriptar contraseña

    $stmt = $conn->prepare("CALL InsertarMedico(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellido, $especialidad, $telefono, $correo, $contraseña);

    if ($stmt->execute()) {
        $mensaje = "✅ Médico registrado exitosamente.";
    } else {
        $mensaje = "❌ Error al registrar médico: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Médico</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Médico</h2>
        <?php if (!empty($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
        <form action="agregar_medico.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" required>

            <label for="especialidad">Especialidad:</label>
            <input type="text" name="especialidad" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="correo" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" required>

            <button type="submit" class="btn">Registrar Médico</button>
        </form>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
