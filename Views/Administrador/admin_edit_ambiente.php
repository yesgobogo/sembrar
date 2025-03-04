<?php
session_start();
require_once '../../Models/conexion.php'; // Conexión a la BD

$db = new Conexion();
$conn = $db->get_conexion();

// **AGREGAR AMBIENTE**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    $nombre = trim($_POST['nombre']);
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    $query = "INSERT INTO ambientes (nombre_ambiente, disponible) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nombre, $disponible]);

    header("Location: ambientes.php");
    exit();
}

// **EDITAR AMBIENTE**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    $query = "UPDATE ambientes SET nombre_ambiente = ?, disponible = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nombre, $disponible, $id]);

    header("Location: ambientes.php");
    exit();
}

// **ELIMINAR AMBIENTE**
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    $query = "DELETE FROM ambientes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);

    header("Location: ambientes.php");
    exit();
}

// **CAMBIAR ESTADO**
if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];

    // Obtener el estado actual
    $query = "SELECT disponible FROM ambientes WHERE id_ambiente = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $ambiente = $stmt->fetch(PDO::FETCH_ASSOC);

    $nuevoEstado = $ambiente['disponible'] ? 0 : 1; // Alternar estado

    $query = "UPDATE ambientes SET disponible = ? WHERE id_ambiente = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nuevoEstado, $id]);

    header("Location: ambientes.php");
    exit();
}

// **OBTENER AMBIENTES**
$query = "SELECT * FROM ambientes";
$stmt = $conn->prepare($query);
$stmt->execute();
$ambientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Ambientes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Gestión de Ambientes</h1>

    <!-- Formulario para Agregar Nuevo Ambiente -->
    <h2>Agregar Nuevo Ambiente</h2>
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre del Ambiente" required>
        <label>
            <input type="checkbox" name="disponible" checked> Disponible
        </label>
        <button type="submit" name="agregar">Agregar</button>
    </form>

    <!-- Tabla de Ambientes -->
    <h2>Lista de Ambientes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        
        <?php if (!empty($ambientes) && is_array($ambientes)): ?>
    <?php foreach ($ambientes as $ambiente): ?>
        <tr>
            <td><?= isset($ambiente['id_ambiente']) ? htmlspecialchars($ambiente['id_ambiente']) : '' ?></td>
            <td><?= isset($ambiente['nombre_ambiente']) ? htmlspecialchars($ambiente['nombre_ambiente']) : 'Sin nombre' ?></td>
            <td>
                <?= isset($ambiente['disponible']) && $ambiente['disponible'] ? '✅ Disponible' : '❌ Ocupado' ?>
                <a href="?toggle=<?= $ambiente['id'] ?>">Cambiar</a>
            </td>
            <td>
                <a href="?editar=<?= $ambiente['id'] ?>">Editar</a>
                <a href="?eliminar=<?= $ambiente['id'] ?>" onclick="return confirm('¿Eliminar este ambiente?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="4">No hay ambientes registrados.</td>
    </tr>
<?php endif; ?>


    </table>

    <!-- Formulario para Editar Ambiente (Solo si se ha seleccionado uno) -->
<?php
if (isset($_GET['editar']) && is_numeric($_GET['editar'])) { 
    $id_editar = (int) $_GET['editar'];
    
    // Verifica que la conexión a la BD está activa
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Consulta para obtener los datos del ambiente
    $query = "SELECT * FROM ambientes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id_editar]);
    $ambienteEditar = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ambienteEditar) {
        die("Error: Ambiente no encontrado.");
    }
?>
    <h2>Editar Ambiente</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($ambienteEditar['id']) ?>">
        <input type="text" name="nombre" value="<?= htmlspecialchars($ambienteEditar['nombre_ambiente']) ?>" required>
        <label>
            <input type="checkbox" name="disponible" <?= $ambienteEditar['disponible'] ? 'checked' : '' ?>> Disponible
        </label>
        <button type="submit" name="editar">Guardar Cambios</button>
    </form>
<?php 
} // Cierra el if de edición correctamente
?>
</body>
</html>