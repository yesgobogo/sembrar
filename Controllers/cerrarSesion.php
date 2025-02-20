<?php

    require_once("../Models/conexion.php");
    require_once("../Models/consultas.php");


    $objSesion = new ValidarSesion();
    $result = $objSesion-> cerrarSesion();



?>