<?php
    // ENLAZAMOS LAS DEPENDENCIAS
    require_once("../Models/conexion.php");
    require_once("../Models/consultas.php");

    $email = $_POST['email'];
    $clave = md5($_POST['clave']);

    if ( strlen($email)>0 && strlen($clave)>0 ) {
        
        $objValidar = new ValidarSesion();
        $result = $objValidar->iniciarSesion($email,$clave);
        
    }else{
        echo '<script>alert("Ingrese Usuario y clave")</script>';
        echo "<script> location.href='../Views/Extras/page-login.html' </script>";
    }


?>
