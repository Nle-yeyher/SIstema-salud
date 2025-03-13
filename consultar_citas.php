<?php
include 'conexion.php';

$query = "CALL ObtenerCitas()";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Citas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Consultar Citas</h2>
        <table>
            <tr>
                <th>ID Cita</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id_cita']; ?></td>
                    <td><?php echo $row['paciente']; ?></td>
                    <td><?php echo $row['medico']; ?></td>
                    <td><?php echo $row['fecha']; ?></td>
                    <td><?php echo $row['hora']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
