<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_paciente = $_POST['id_paciente'];
    $id_medico = $_POST['id_medico'];
    $detalles = $_POST['detalles'];
    $total = $_POST['total'];
    $fecha = $_POST['fecha']; // La fecha se obtiene del formulario

    if (empty($fecha)) {
        $fecha = date("Y-m-d"); // Si la fecha está vacía, usar la actual
    }

    // Llamar al procedimiento almacenado
    $stmt = $conn->prepare("CALL GenerarFactura(?, ?, ?, ?, ?, @id_factura)");
    $stmt->bind_param("iisss", $id_paciente, $id_medico, $detalles, $total, $fecha);
    
    if ($stmt->execute()) {
        // Obtener el ID de la factura generada
        $result = $conn->query("SELECT @id_factura AS id_factura");
        $row = $result->fetch_assoc();
        $id_factura = $row['id_factura'];

        $stmt->close();
        $conn->close();

        // Redirigir a la página de la factura
        header("Location: ver_factura.php?id_factura=$id_factura");
        exit();
    } else {
        echo "Error al generar la factura: " . $stmt->error;
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
    <title>Generar Factura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Generar Factura</h2>
        <form action="generar_factura.php" method="POST">
            <label for="id_paciente">ID Paciente:</label>
            <input type="number" name="id_paciente" required>

            <label for="id_medico">ID Médico:</label>
            <input type="number" name="id_medico" required>

            <label for="detalles">Detalles:</label>
            <textarea name="detalles" required></textarea>

            <label for="total">Total a pagar ($):</label>
            <input type="number" step="0.01" name="total" required>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" required>

            <button type="submit" class="btn">Generar Factura</button>
        </form>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
