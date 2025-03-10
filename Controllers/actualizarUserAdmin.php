<?php

// ENLAZAMOS LAS DEPENDENCIAS NECESARIAS  
require_once("../Models/conexion.php");
require_once("../Models/consultas.php");    

// ATERRIZAMOS EN VARIABLES LOS DATOS INGRESADOS POR EL USUARIO
$identificacion = $_POST['identificacion'];
$tipo_doc = $_POST['tipo_doc'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];
$tipo_formacion = $_POST['tipo_formacion'];

// VALIDAMOS QUE LOS CAMPOS ESTÉN COMPLETAMENTE DILIGENCIADOS
if (strlen($identificacion) > 0 && strlen($tipo_doc) > 0 && strlen($nombres) > 0 && strlen($apellidos) > 0 &&  
    strlen($email) > 0 && strlen($telefono) > 0 && strlen($rol) > 0 && strlen($estado) > 0 && strlen($tipo_formacion) > 0) {
    
    // CREAMOS EL OBJETO DE LA CLASE CONSULTAS Y LLAMAMOS A LA FUNCIÓN
    $objConsultas = new Consultas();
    $result = $objConsultas->actualizarUserAdmin($identificacion, $tipo_doc, $nombres, $apellidos, $email, $telefono, $rol, $estado, $tipo_formacion);

    // VERIFICAMOS EL RESULTADO DE LA ACTUALIZACIÓN
    if ($resultado) {
        echo '<script>alert("Usuario actualizado correctamente")</script>';
        echo "<script> location.href='../Views/Administrador/ver-usuarios.php'</script>";
    } else {
        echo '<script>alert("Error al actualizar usuario o no se realizaron cambios")</script>';
        echo "<script> location.href='../Views/Administrador/ver-usuarios.php'</script>";
    }

} else {
    echo '<script>alert("Por favor complete todos los campos")</script>';
    echo "<script> location.href='../Views/Administrador/ver-usuarios.php'</script>";
}

?>
