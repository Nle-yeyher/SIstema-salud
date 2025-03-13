<?php
include 'conexion.php';

$mensaje = ""; // Variable para almacenar el mensaje de resultado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_paciente = $_POST['id_paciente'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // Llamar al procedimiento almacenado con los 8 parámetros correctos
    $stmt = $conn->prepare("CALL ActualizarPaciente(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $id_paciente, $nombre, $apellido, $fecha_nacimiento, $genero, $direccion, $telefono, $correo);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $mensaje = "Paciente actualizado correctamente.";
        } else {
            $mensaje = "No se realizó ninguna actualización. Verifique los datos.";
        }
    } else {
        $mensaje = "Error al actualizar paciente: " . $stmt->error;
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
    <title>Actualizar Paciente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Actualizar Paciente</h2>
        <?php if (!empty($mensaje)) : ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <form action="actualizar_paciente.php" method="POST">
            <label for="id_paciente">ID Paciente:</label>
            <input type="number" name="id_paciente" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" required>

            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" required>

            <label for="genero">Género:</label>
            <select name="genero" required>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="correo" required>

            <button type="submit" class="btn">Actualizar Paciente</button>
        </form>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
