<?php
session_start();
    require_once '../../Models/conexion.php'; // Conexión a la BD
    require_once("../../Models/consultas.php");
    require_once("../../Models/seguridadAdministrador.php");
    require_once("../../Controllers/mostrarInfoAdmin.php");

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
    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">

    <!-- Toastr -->
    <link href="../Dashboard/css/lib/toastr/toastr.min.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="../Dashboard/css/lib/sweetalert/sweetalert.css" rel="stylesheet">
    <!-- Range Slider -->
    <link href="../Dashboard/css/lib/rangSlider/ion.rangeSlider.css" rel="stylesheet">
    <link href="../Dashboard/css/lib/rangSlider/ion.rangeSlider.skinFlat.css" rel="stylesheet">
    <!-- Bar Rating -->
    <link href="../Dashboard/css/lib/barRating/barRating.css" rel="stylesheet">
    <!-- Nestable -->
    <link href="../Dashboard/css/lib/nestable/nestable.css" rel="stylesheet">
    <!-- JsGrid -->
    <link href="../Dashboard/css/lib/jsgrid/jsgrid-theme.min.css" rel="stylesheet" />
    <link href="../Dashboard/css/lib/jsgrid/jsgrid.min.css" type="text/css" rel="stylesheet" />
    <!-- Datatable -->
    <link href="../Dashboard/css/lib/datatable/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="../Dashboard/css/lib/data-table/buttons.bootstrap.min.css" rel="stylesheet" />
    <!-- Calender 2 -->
    <link href="../Dashboard/css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    <!-- Weather Icon -->
    <link href="../Dashboard/css/lib/weather-icons.css" rel="stylesheet" />
    <!-- Owl Carousel -->
    <link href="../Dashboard/css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="../Dashboard/css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <!-- Select2 -->
    <link href="../Dashboard/css/lib/select2/select2.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link href="../Dashboard/css/lib/chartist/chartist.min.css" rel="stylesheet">
    <!-- Calender -->
    <link href="../Dashboard/css/lib/calendar/fullcalendar.css" rel="stylesheet" />

    <!-- Common -->
    <link href="../Dashboard/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="../Dashboard/css/lib/themify-icons.css" rel="stylesheet">
    <link href="../Dashboard/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="../Dashboard/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="../Dashboard/css/lib/helper.css" rel="stylesheet">
    <link href="../Dashboard/css/style.css" rel="stylesheet">
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
                    <a href="?editar=<?= $ambiente['Id_ambiente'] ?>" class="btn btn-sm btn-info">Editar</a>
                    <a href="?eliminar=<?= $ambiente['Id_ambiente'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este ambiente?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['editar']) && is_numeric($_GET['editar'])) {
        $id_editar = $_GET['editar'];
        
        $query = "SELECT * FROM ambientes WHERE Id_ambiente = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id_editar]);
        $ambienteEditar = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($ambienteEditar):
    ?>
        <h2>Editar Ambiente</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($ambienteEditar['Id_ambiente']) ?>">
            <div class="mb-3">
                <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($ambienteEditar['nombre_ambiente']) ?>" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="disponible" <?= $ambienteEditar['disponible'] ? 'checked' : '' ?>>
                <label class="form-check-label">Disponible</label>
            </div>
            <button type="submit" name="editar" class="btn btn-success">Guardar Cambios</button>
        </form>
    <?php 
        endif;
    }
    ?>
</body>
</html>

