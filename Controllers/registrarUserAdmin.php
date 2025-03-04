<?php
require_once("../Models/conexion.php");

try {
    // Creamos el objeto de conexión
    $conexion = new Conexion();
    $pdo = $conexion->get_conexion();

    // Verificamos que los datos llegaron por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $identificacion = trim($_POST['identificacion']);
        $tipo_doc = trim($_POST['tipo_doc']);
        $nombres = trim($_POST['nombres']);
        $apellidos = trim($_POST['apellidos']);
        $email = trim($_POST['email']);
        $telefono = trim($_POST['telefono']);
        $clave = trim($_POST['identificacion']); // Se usa la identificación como clave
        $rol = trim($_POST['rol']); // Cliente, Instructor o Administrador
        $estado = trim($_POST['estado']); // Pendiente, Activo o Inactivo

        // Validamos que los campos no estén vacíos
        if (!empty($identificacion) && !empty($tipo_doc) && !empty($nombres) && !empty($apellidos) &&
            !empty($email) && !empty($telefono) && !empty($clave) && !empty($rol) && !empty($estado)) {
            
            // Encriptamos la clave con MD5
            $claveMd = md5($clave);

            // Procesamos la imagen
            if (!empty($_FILES['foto']['name'])) {
                $foto = "../Uploads/Usuarios/" . basename($_FILES['foto']['name']);
                move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
            } else {
                $foto = NULL;
            }

            // Insertamos los datos en la base de datos con PDO
            $sql = "INSERT INTO users (identificacion, tipo_doc, nombres, apellidos, email, telefono, clave, rol, estado, foto)
                    VALUES (:identificacion, :tipo_doc, :nombres, :apellidos, :email, :telefono, :clave, :rol, :estado, :foto)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":identificacion", $identificacion);
            $stmt->bindParam(":tipo_doc", $tipo_doc);
            $stmt->bindParam(":nombres", $nombres);
            $stmt->bindParam(":apellidos", $apellidos);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":telefono", $telefono);
            $stmt->bindParam(":clave", $claveMd);
            $stmt->bindParam(":rol", $rol);
            $stmt->bindParam(":estado", $estado);
            $stmt->bindParam(":foto", $foto);

            if ($stmt->execute()) {
                echo '<script>alert("Registro exitoso");</script>';
                echo "<script>location.href='../Views/Extras/page-register.html';</script>";
            } else {
                echo '<script>alert("Error al registrar");</script>';
                echo "<script>location.href='../Views/Extras/page-register.html';</script>";
            }
        } else {
            echo '<script>alert("Por favor, complete todos los campos");</script>';
            echo "<script>location.href='../Views/Extras/page-register.html';</script>";
        }
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>


