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

    $query = "UPDATE ambientes SET nombre_ambiente = ?, disponible = ? WHERE Id_ambiente = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nombre, $disponible, $id]);

    header("Location: ambientes.php");
    exit();
}

// **ELIMINAR AMBIENTE**
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    $query = "DELETE FROM ambientes WHERE Id_ambiente = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);

    header("Location: ambientes.php");
    exit();
}

// **CAMBIAR ESTADO**
if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    $id = $_GET['toggle'];

    $query = "UPDATE ambientes SET disponible = NOT disponible WHERE Id_ambiente = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);

    header("Location: ambientes.php");
    exit();
}

// **OBTENER AMBIENTES**
$query = "SELECT * FROM ambientes ORDER BY Id_ambiente ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$ambientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Ambientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>


<body class="container mt-4">
    <h1 class="mb-4">Gestión de Ambientes</h1>

    <h2>Agregar Nuevo Ambiente</h2>
    <form method="post" class="mb-4">
        <div class="mb-3">
            <input type="text" class="form-control" name="nombre" placeholder="Nombre del Ambiente" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="disponible" checked>
            <label class="form-check-label">Disponible</label>
        </div>
        <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
    </form>

    <h2>Lista de Ambientes</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ambientes as $ambiente): ?>
            <tr>
                <td><?= htmlspecialchars($ambiente['Id_ambiente']) ?></td>
                <td><?= htmlspecialchars($ambiente['nombre_ambiente']) ?></td>
                <td>
                    <?= $ambiente['disponible'] ? '<span class="text-success">✅ Disponible</span>' : '<span class="text-danger">❌ Ocupado</span>' ?>
                    <a href="?toggle=<?= $ambiente['Id_ambiente'] ?>" class="btn btn-sm btn-warning">Cambiar</a>
                </td>
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal" 
                        data-id="<?= $ambiente['Id_ambiente'] ?>" 
                        data-nombre="<?= htmlspecialchars($ambiente['nombre_ambiente']) ?>" 
                        data-disponible="<?= $ambiente['disponible'] ?>">Editar</button>
                        
                    <a href="?eliminar=<?= $ambiente['Id_ambiente'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este ambiente?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

                
    
    <!-- Modal de Edición -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Ambiente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nombre" id="edit-nombre" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="disponible" id="edit-disponible">
                            <label class="form-check-label">Disponible</label>
                        </div>
                        <button type="submit" name="editar" class="btn btn-success">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nombre = button.getAttribute('data-nombre');
            var disponible = button.getAttribute('data-disponible') == 1;

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-disponible').checked = disponible;
        });
    </script>

</body>
</html>