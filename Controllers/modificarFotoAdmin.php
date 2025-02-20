<?php

    require_once("../Models/conexion.php");
    require_once("../Models/consultas.php");

    $id = $_POST['identificacion'];

    $foto = "../Uploads/Usuarios/".$_FILES['foto']['name'];

    $resultado = move_uploaded_file($_FILES['foto']['tmp_name'], $foto);

    $objConsultas = new Consultas();
    $result = $objConsultas->actualizarFotoAdmin($id, $foto);

?>