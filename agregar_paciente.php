<?php
include 'conexion.php';

$mensaje = ""; // Variable para mostrar mensajes

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    $sql = "CALL InsertarPaciente(?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssssss", $nombre, $apellido, $fecha_nacimiento, $genero, $direccion, $telefono, $correo, $contraseña);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $mensaje = "<p class='success'>Paciente agregado con éxito.</p>";
            } else {
                $mensaje = "<p class='warning'>No se pudo agregar el paciente. Puede que el correo ya esté registrado.</p>";
            }
        } else {
            $mensaje = "<p class='error'>Error al agregar el paciente: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        $mensaje = "<p class='error'>Error en la preparación de la consulta: " . $conn->error . "</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Paciente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Paciente</h2>

        <?php if (!empty($mensaje)) echo $mensaje; ?>

        <form method="POST" action="">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>
            
            <label>Apellido:</label>
            <input type="text" name="apellido" required>
            
            <label>Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" required>
            
            <label>Género:</label>
            <input type="text" name="genero" required>
            
            <label>Dirección:</label>
            <input type="text" name="direccion" required>
            
            <label>Teléfono:</label>
            <input type="text" name="telefono" required>
            
            <label>Correo:</label>
            <input type="email" name="correo" required>
            
            <label>Contraseña:</label>
            <input type="password" name="contraseña" required>
            
            <button type="submit">Agregar</button>
        </form>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
