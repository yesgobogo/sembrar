<?php
// session_start();
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

    $query = "UPDATE ambientes SET nombre_ambiente = ?, disponible = ? WHERE id_ambiente = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nombre, $disponible, $id]);

    header("Location: ambientes.php");
    exit();
}

// **ELIMINAR AMBIENTE**
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    $query = "DELETE FROM ambientes WHERE id_ambiente = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);

    header("Location: ambientes.php");
    exit();
}

// **CAMBIAR ESTADO**
if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    $id = $_GET['toggle'];

    $query = "SELECT disponible FROM ambientes WHERE id_ambiente = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $ambiente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ambiente) {
        $nuevoEstado = $ambiente['disponible'] ? 0 : 1;

        $query = "UPDATE ambientes SET disponible = ? WHERE id_ambiente = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nuevoEstado, $id]);
    }

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
<body>
    <h1>Gestión de Ambientes</h1>

    <h2>Agregar Nuevo Ambiente</h2>
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre del Ambiente" required>
        <label>
            <input type="checkbox" name="disponible" checked> Disponible
        </label>
        <button type="submit" name="agregar">Agregar</button>
    </form>

    <h2>Lista de Ambientes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        
        <?php foreach ($ambientes as $ambiente): ?>
        <tr>
            <td><?= htmlspecialchars($ambiente['id_ambiente']) ?></td>
            <td><?= htmlspecialchars($ambiente['nombre_ambiente']) ?></td>
            <td>
                <?= $ambiente['disponible'] ? '✅ Disponible' : '❌ Ocupado' ?>
                <a href="?toggle=<?= $ambiente['id_ambiente'] ?>">Cambiar</a>
            </td>
            <td>
                <a href="?editar=<?= $ambiente['id_ambiente'] ?>">Editar</a>
                <a href="?eliminar=<?= $ambiente['id_ambiente'] ?>" onclick="return confirm('¿Eliminar este ambiente?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php
    if (isset($_GET['editar']) && is_numeric($_GET['editar'])) {
        $id_editar = $_GET['editar'];
        
        $query = "SELECT * FROM ambientes WHERE id_ambiente = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id_editar]);
        $ambienteEditar = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($ambienteEditar):
    ?>
        <h2>Editar Ambiente</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($ambienteEditar['id_ambiente']) ?>">
            <input type="text" name="nombre" value="<?= htmlspecialchars($ambienteEditar['nombre_ambiente']) ?>" required>
            <label>
                <input type="checkbox" name="disponible" <?= $ambienteEditar['disponible'] ? 'checked' : '' ?>> Disponible
            </label>
            <button type="submit" name="editar">Guardar Cambios</button>
        </form>
    <?php 
        endif;
    }
    ?>
</body>
</html>

