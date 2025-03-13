<?php
include 'conexion.php';

$paciente = null;
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_paciente = $_POST['id_paciente'];
    $stmt = $conn->prepare("CALL ObtenerPacientes(?)");
    $stmt->bind_param("i", $id_paciente);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $paciente = $result->fetch_assoc();
    } else {
        $mensaje = "No hay paciente con ese ID.";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Paciente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Buscar Paciente</h2>
        <form method="POST">
            <label for="id_paciente">ID del Paciente:</label>
            <input type="number" name="id_paciente" required>
            <button type="submit" class="btn">Buscar</button>
        </form>
        
        <?php if ($paciente) { ?>
            <h3>Información del Paciente</h3>
            <p><strong>ID:</strong> <?php echo $paciente['id_paciente']; ?></p>
            <p><strong>Nombre:</strong> <?php echo $paciente['nombre']; ?></p>
            <p><strong>Apellido:</strong> <?php echo $paciente['apellido']; ?></p>
            <p><strong>Fecha de Nacimiento:</strong> <?php echo $paciente['fecha_nacimiento']; ?></p>
            <p><strong>Género:</strong> <?php echo $paciente['genero']; ?></p>
            <p><strong>Dirección:</strong> <?php echo $paciente['direccion']; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $paciente['telefono']; ?></p>
            <p><strong>Correo:</strong> <?php echo $paciente['correo']; ?></p>
        <?php } elseif ($mensaje) { ?>
            <p class="error"> <?php echo $mensaje; ?> </p>
        <?php } ?>
        
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>