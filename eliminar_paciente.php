<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_paciente'];
    
    $sql = "CALL EliminarPaciente(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Paciente eliminado con éxito.";
    } else {
        echo "Error al eliminar el paciente.";
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
    <title>Eliminar Paciente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Eliminar Paciente</h2>
        <form method="POST" action="">
            <label>ID Paciente:</label>
            <input type="number" name="id_paciente" required>
            <button type="submit">Eliminar</button>
        </form>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
