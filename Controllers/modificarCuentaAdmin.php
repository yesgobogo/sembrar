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
    
    // Verificamos que las claves coincidan

    
        // VALIDAMOS QUE LOS CAMPOS ESTEN COMPLETAMENTE DILIGENCIADOS
        if ( strlen($identificacion)>0 && strlen($tipo_doc)>0 && strlen($nombres)>0 && strlen($apellidos)>0 &&  strlen($email)>0 && strlen($telefono)>0 ) {
            
            
            // CREAMOS EL OBJETO A PARTIR DE LA CLASE
            // PARA ENVIAR LOS ARGUMENTOS A LA FUNCION EN EL MODELO.(ARCHIVO CONSULTAS)
            $objConsultas = new Consultas();
            $result = $objConsultas->modificarCuentaAdmin($identificacion,$tipo_doc,$nombres,$apellidos,$email,$telefono);


        }
        else{
            echo '<script>alert("Por favor complete todos los campos")</script>';
            echo "<script> location.href='../Views/Administrador/ver-usuarios.php'</script>";
        }
        
    

?>
