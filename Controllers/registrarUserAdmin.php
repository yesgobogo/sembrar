<?php
// ENLAZAMOS LAS DEPENDENCIAS NECESARIAS  
require_once("../Models/conexion.php");
require_once("../Models/consultas.php");

// ATERRIZAMOS LOS DATOS INGRESADOS POR EL USUARIO A TRAVÉS DEL METHOD POST
$identificacion = trim($_POST['identificacion']);
$tipo_doc = trim($_POST['tipo_doc']);
$nombres = trim($_POST['nombres']);
$apellidos = trim($_POST['apellidos']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$clave = trim($_POST['identificacion']); // Contraseña por defecto igual a la identificación
$rol = "instructor"; // Puedes cambiarlo a "administrador" si es necesario
$estado = "pendiente";
$tipo_formacion = "tecnico"; // Debes permitir al usuario elegir entre 'tecnico' o 'tecnologo'

// VALIDAMOS QUE TODOS LOS CAMPOS ESTÉN COMPLETAMENTE LLENOS
if (!empty($identificacion) && !empty($tipo_doc) && !empty($nombres) && !empty($apellidos) && 
    !empty($email) && !empty($telefono) && !empty($clave) && !empty($tipo_formacion)) {

    // ENCRIPTAMOS LA CLAVE CON PASSWORD_HASH (Más seguro que md5)
    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

    // PROCESAMOS LA IMAGEN SOLO SI SE HA SUBIDO
    if (!empty($_FILES['foto']['name'])) {
        $directorio = "../Uploads/Usuarios/";
        $nombreFoto = basename($_FILES['foto']['name']);
        $rutaFoto = $directorio . $nombreFoto;
        
        // MOVEMOS EL ARCHIVO A LA CARPETA DE DESTINO
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFoto)) {
            echo '<script>alert("Error al subir la imagen")</script>';
            echo "<script> location.href='../Views/Extras/page-register.html' </script>";
            exit();
        }
    } else {
        $rutaFoto = "../Uploads/Usuarios/default.png"; // Imagen por defecto si no se sube ninguna
    }

    // CREAMOS EL OBJETO DE LA CLASE CONSULTAS
    $objConsultas = new Consultas();

    // VERIFICAMOS SI EL EMAIL YA ESTÁ REGISTRADO PARA EVITAR DUPLICADOS
    $objConsultas = new Consultas();
if ($objConsultas->verificarEmailExistente($email)) {
    echo '<script>alert("El correo ya está registrado. Usa otro.")</script>';
    echo "<script> location.href='../Views/Extras/page-register.html' </script>";
} else {
    $result = $objConsultas->insertarUserAdmin($identificacion, $tipo_doc, $nombres, $apellidos, $email, $telefono, $claveMd, $rol, $estado, $foto);
}


    // INSERTAMOS EL USUARIO EN LA BASE DE DATOS
    
    $result = $objConsultas->insertarUserAdmin($identificacion, $tipo_doc, $nombres, $apellidos, $email, $telefono, $claveHash, $rol, $estado, $tipo_formacion, $rutaFoto);

    if ($result) {
        echo '<script>alert("Usuario registrado correctamente")</script>';
        echo "<script> location.href='../Views/Extras/page-login.html' </script>";
    } else {
        echo '<script>alert("Error al registrar usuario")</script>';
        echo "<script> location.href='../Views/Extras/page-register.html' </script>";
    }
} else {
    echo '<script>alert("Por favor complete todos los campos")</script>';
    echo "<script> location.href='../Views/Extras/page-register.html' </script>";
}
?>

