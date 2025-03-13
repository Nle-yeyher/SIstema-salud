<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cita = $_POST["id_cita"];

    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "sistemasalud");

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Preparar la llamada al procedimiento almacenado
    $stmt = $conn->prepare("CALL CancelarCita(?)");
    $stmt->bind_param("i", $id_cita);

    // Ejecutar y verificar resultado
    if ($stmt->execute()) {
        echo "<script>alert('✅ Cita cancelada correctamente.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('❌ Error al cancelar la cita: " . $stmt->error . "');</script>";
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
    <title>Cancelar Cita</title>
    <link rel="stylesheet" href="style.css"> <!-- Asegúrate de que el CSS esté enlazado correctamente -->
</head>
<body>
    <div class="container">
        <h2>Cancelar Cita</h2>
        <form action="cancelar_cita.php" method="POST" class="form-container">
            <label for="id_cita">ID de la Cita:</label>
            <input type="number" name="id_cita" required>

            <button type="submit" class="btn">Cancelar Cita</button>
        </form>
    </div>
</body>
</html>
