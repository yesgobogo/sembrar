<?php
include("menu-include.php"); // Se incluye el menú
include("conexion.php"); // Conexión a la base de datos

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];

    $sql = "INSERT INTO ambientes (nombre) VALUES ('$nombre')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Ambiente registrado correctamente');</script>";
    } else {
        echo "<script>alert('Error al registrar el ambiente');</script>";
    }
}

// Obtener la lista de ambientes
$sql = "SELECT * FROM ambientes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Ambientes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Registrar Nuevo Ambiente</h2>
    <form method="POST" action="">
        <label for="nombre">Nombre del Ambiente:</label>
        <input type="text" name="nombre" required>
        <button type="submit">Registrar</button>
    </form>

    <h2>Lista de Ambientes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["nombre"]; ?></td>
                <td>
                    <a href="editar_ambiente.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="eliminar_ambiente.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este ambiente?');">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>

