<?php
include 'conexion.php';

if (!isset($_GET['id_factura'])) {
    echo "ID de factura no especificado.";
    exit();
}

$id_factura = $_GET['id_factura'];

$stmt = $conn->prepare("SELECT f.id_factura, f.fecha, f.detalles, f.total, 
                        p.nombre AS paciente, m.nombre AS medico
                        FROM facturas f
                        JOIN pacientes p ON f.id_paciente = p.id_paciente
                        JOIN medicos m ON f.id_medico = m.id_medico
                        WHERE f.id_factura = ?");
$stmt->bind_param("i", $id_factura);
$stmt->execute();
$result = $stmt->get_result();
$factura = $result->fetch_assoc();

if (!$factura) {
    echo "Factura no encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #<?php echo $factura['id_factura']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Factura #<?php echo $factura['id_factura']; ?></h2>
        <p><strong>Fecha:</strong> <?php echo $factura['fecha']; ?></p>
        <p><strong>Paciente:</strong> <?php echo $factura['paciente']; ?></p>
        <p><strong>Médico:</strong> <?php echo $factura['medico']; ?></p>
        <p><strong>Detalles:</strong> <?php echo $factura['detalles']; ?></p>
        <p><strong>Total a pagar:</strong> $<?php echo number_format($factura['total'], 2); ?></p>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
