<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_paciente = $_POST["id_paciente"];
    $id_medico = $_POST["id_medico"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $motivo = $_POST["motivo"];

    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "sistemasalud");

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Preparar la llamada al procedimiento almacenado
    $stmt = $conn->prepare("CALL InsertarCita(?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $id_paciente, $id_medico, $fecha, $hora, $motivo);

    // Ejecutar y verificar resultado
    if ($stmt->execute()) {
        echo "<script>alert('✅ Cita registrada correctamente.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('❌ Error al registrar la cita: " . $stmt->error . "');</script>";
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cita</title>
    <link rel="stylesheet" href="style.css"> <!-- Asegúrate de que tu archivo CSS esté correctamente enlazado -->
</head>
<body>
    <div class="container">
        <h2>Registrar Cita</h2>
        <form action="registrar_cita.php" method="POST" class="form-container">
            <label for="id_paciente">ID Paciente:</label>
            <input type="number" name="id_paciente" required>

            <label for="id_medico">ID Médico:</label>
            <input type="number" name="id_medico" required>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required>

            <label for="hora">Hora:</label>
            <input type="time" name="hora" required>

            <label for="motivo">Motivo:</label>
            <textarea name="motivo" required></textarea>

            <button type="submit" class="btn">Registrar Cita</button>
        </form>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
