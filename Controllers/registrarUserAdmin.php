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
    $clave = $_POST['identificacion'];
    $rol = "Cliente";
    $estado = "Pendiente";

    // Verificamos que las claves coincidan

    
        // VALIDAMOS QUE LOS CAMPOS ESTEN COMPLETAMENTE DILIGENCIADOS
        if ( strlen($identificacion)>0 && strlen($tipo_doc)>0 && strlen($nombres)>0 && strlen($apellidos)>0 &&  strlen($email)>0 && strlen($telefono)>0 && strlen($clave)>0) {
            
            // ENCRIPTAMOS LA CLAVE
            $claveMd = md5($clave);

            // CREAMOS UNA VARIABLE PARA DEFINIR LA RUTA DONDE QUEDARA ALOJADA LA IMAGEN
            $foto = "../Uploads/Usuarios/".$_FILES['foto']['name'];
            // MOVEMOS EL ARCHIVO A LA CARPETA UPLOADS Y LA CARPETA USUARIOS
            $mover = move_uploaded_file($_FILES['foto']['tmp_name'], $foto);

            // CREAMOS EL OBJETO A PARTIR DE LA CLASE
            // PARA ENVIAR LOS ARGUMENTOS A LA FUNCION EN EL MODELO.(ARCHIVO CONSULTAS)
            $objConsultas = new Consultas();
            $result = $objConsultas->insertarUserAdmin($identificacion,$tipo_doc,$nombres,$apellidos,$email,$telefono,$claveMd,$rol,$estado,$foto);


        }
        else{
            echo '<script>alert("Por favor complete todos los campos")</script>';
            echo "<script> location.href='../Views/Extras/page-register.html' </script>";
        }
        
    

?>
