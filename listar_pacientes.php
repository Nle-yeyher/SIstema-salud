<?php
include 'conexion.php';

$sql = "CALL ListarPacientes()";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pacientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Lista de Pacientes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Teléfono</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id_paciente']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['correo']; ?></td>
                    <td><?php echo $row['telefono']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
<?php $conn->close(); ?>
