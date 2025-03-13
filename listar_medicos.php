<?php
include 'conexion.php';

$resultado = $conn->query("CALL ListarMedicos()");

$medicos = [];
if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $medicos[] = $fila;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Médicos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Lista de Médicos</h2>
        <?php if (empty($medicos)): ?>
            <p>No hay médicos registrados.</p>
        <?php else: ?>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Especialidad</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                </tr>
                <?php foreach ($medicos as $medico): ?>
                    <tr>
                        <td><?php echo $medico['id_medico']; ?></td>
                        <td><?php echo $medico['nombre']; ?></td>
                        <td><?php echo $medico['apellido']; ?></td>
                        <td><?php echo $medico['especialidad']; ?></td>
                        <td><?php echo $medico['telefono']; ?></td>
                        <td><?php echo $medico['correo']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <a href="index.php" class="btn">Volver</a>
    </div>
</body>
</html>
