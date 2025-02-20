<?php
    
    require_once("../Models/conexion.php");
    require_once("../Models/consultas.php");
    // 
    $id = $_GET['id'];

    $objConsultas = new Consultas();
    $result = $objConsultas->eliminarUserAdmin($id);


?>