<?php

    // ENLAZAMOS LAS DEPEDENCIAS NECESARIAS  
    require_once("../Models/conexion.php");
    require_once("../Models/consultas.php");    

    // ATERRIZAMOS EN VARIABLES LOS DATOS INGRESADOS
    // POR EL USUARIO, LOS CUALES VIAJAN A TRAVÉS DEL 
    // METHOD POST Y LOS NAME DE LOS CAMPOS

    $identificacion = $_POST['identificacion'];
    $tipo_doc = $_POST['tipo_doc'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $clave = $_POST['clave'];
    $clave2 = $_POST['clave2'];
    $rol = "Cliente";
    $estado = "Pendiente";

    // Verificamos que las claves coincidan

    if ($clave == $clave2) {
        // VALIDAMOS QUE LOS CAMPOS ESTEN COMPLETAMENTE DILIGENCIADOS
        if ( strlen($identificacion)>0 && strlen($tipo_doc)>0 && strlen($nombres)>0 && strlen($apellidos)>0 &&  strlen($email)>0 && strlen($telefono)>0 && strlen($clave)>0) {
            
            // ENCRIPTAMOS LA CLAVE
            $claveMd = md5($clave);

            // CREAMOS EL OBJETO A PARTIR DE LA CLASE
            // PARA ENVIAR LOS ARGUMENTOS A LA FUNCION EN EL MODELO.(ARCHIVO CONSULTAS)
            $objConsultas = new Consultas();
            $result = $objConsultas->insertarUserEx($identificacion,$tipo_doc,$nombres,$apellidos,$email,$telefono,$claveMd,$rol,$estado);


        }
        else{
            echo '<script>alert("Por favor complete todos los campos")</script>';
            echo "<script> location.href='../Views/Extras/page-register.html' </script>";
        }
        
    }else{
        echo '<script>alert("Las claves no coinciden, en la trampa.")</script>';
        echo "<script> location.href='../Views/Extras/page-register.html' </script>";
    }

?>
