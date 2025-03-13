<?php
include 'conexion.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_paciente = $_POST['id_paciente'];
    $id_medico = $_POST['id_medico'];
    $tratamiento = $_POST['tratamiento'];
    $fecha = $_POST['fecha'];

    $stmt = $conn->prepare("CALL AsignarTratamiento(?, ?, ?, ?)");
    $stmt->bind_param("iiss", $id_paciente, $id_medico, $tratamiento, $fecha);

    if ($stmt->execute()) {
        $mensaje = "Tratamiento asignado correctamente.";
    } else {
        $mensaje = "Error al asignar tratamiento: " . $stmt->error;
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
    <title>Asignar Tratamiento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Asignar Tratamiento</h2>
        <?php if (!empty($mensaje)) echo "<p>$mensaje</p>"; ?>
        <form action="asignar_tratamiento.php" method="POST">
            <label for="id_paciente">ID Paciente:</label>
            <input type="number" name="id_paciente" required>

            <label for="id_medico">ID Médico:</label>
            <input type="number" name="id_medico" required>

            <label for="tratamiento">Descripción del Tratamiento:</label>
            <textarea name="tratamiento" required></textarea>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required>

            <button type="submit" class="btn">Asignar Tratamiento</button>
        </form>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
