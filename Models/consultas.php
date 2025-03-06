<?php
    // CREAMOS UNA CLASE QUE CONTENDRA TODAS LAS FUNCIONES
    // CRUD DEL SISTEMA
    class Consultas{ 

        // FUNCIONES MÓDULO USUARIOS

        public function insertarUserEx($identificacion,$tipo_doc,$nombres,$apellidos,$email,$telefono,$claveMd,$rol,$estado,$tipo_formacion){
            
            // CREAMOS EL OBJETO DE CONEXION 
            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();

            
            
            
            // SELECT DE USUARIO REGISTRADO EN EL SISTEMA
            $consultar = "SELECT * FROM users WHERE identificacion=:identificacion OR email=:email";

            $result = $conexion->prepare($consultar);

            $result->bindParam(":identificacion", $identificacion);
            $result->bindParam(":email", $email);

            $result->execute();

            $f = $result->fetch();

            if($f){
                echo '<script>alert("Los datos de usuario ya se encuentran en el sistema")</script>';
                echo "<script> location.href='../Views/Extras/page-register.html' </script>";
            }else{

            
            // CREAMOS LA VARIABLE QUE CONTENDRA LA CONSULTA A EJECUTAR
            $insertar = "INSERT INTO users(identificacion,tipo_doc,nombres,apellidos,email,telefono,clave,rol,estado,tipo_formacion) VALUES(:identificacion,:tipo_doc,:nombres,:apellidos,:email,:telefono,:claveMd,:rol,:estado,:tipo_formacion)";

            // PREPARAMOS TODO LO NECESARIO PARA EJECUTAR LA FUNCION ANTERIOR

            $result = $conexion->prepare($insertar);

            // CONVERTIMOS LOS ARGUMENTOS EN PARAMETROS

            $result->bindParam(":identificacion", $identificacion);
            $result->bindParam(":tipo_doc", $tipo_doc);
            $result->bindParam(":nombres", $nombres);
            $result->bindParam(":apellidos", $apellidos);
            $result->bindParam(":email", $email);
            $result->bindParam(":telefono", $telefono);
            $result->bindParam(":claveMd", $claveMd);
            $result->bindParam(":rol", $rol);
            $result->bindParam(":estado", $estado);
            $result->bindParam(":tipo_formacion", $tipo_formacion);

            // EJECUTAMOS EL INSERT
            $result->execute();

            echo '<script>alert("Usuario Registrado con Exito")</script>';
            echo "<script> location.href='../Views/Extras/page-register.html' </script>";
            }
        }

        public function insertarUserAdmin($identificacion,$tipo_doc,$nombres,$apellidos,$email,$telefono,$claveMd,$rol,$estado,$tipo_formacion,$foto){
            
            // CREAMOS EL OBJETO DE CONEXION 
            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();

            
            
            
            // SELECT DE USUARIO REGISTRADO EN EL SISTEMA
            $consultar = "SELECT * FROM users WHERE identificacion=:identificacion OR email=:email";

            $result = $conexion->prepare($consultar);

            $result->bindParam(":identificacion", $identificacion);
            $result->bindParam(":email", $email);

            $result->execute();

            $f = $result->fetch();

            if($f){
                echo '<script>alert("Los datos de usuario ya se encuentran en el sistema")</script>';
                echo "<script> location.href='../Views/Extras/page-register.html' </script>";
            }else{

            
            // CREAMOS LA VARIABLE QUE CONTENDRA LA CONSULTA A EJECUTAR
            $insertar = "INSERT INTO users(identificacion,tipo_doc,nombres,apellidos,email,telefono,clave,rol,estado,tipo_formacion,foto) VALUES(:identificacion,:tipo_doc,:nombres,:apellidos,:email,:telefono,:claveMd,:rol,:estado,:tipo_formacion,:foto)";

            // PREPARAMOS TODO LO NECESARIO PARA EJECUTAR LA FUNCION ANTERIOR

            $result = $conexion->prepare($insertar);

            // CONVERTIMOS LOS ARGUMENTOS EN PARAMETROS

            $result->bindParam(":identificacion", $identificacion);
            $result->bindParam(":tipo_doc", $tipo_doc);
            $result->bindParam(":nombres", $nombres);
            $result->bindParam(":apellidos", $apellidos);
            $result->bindParam(":email", $email);
            $result->bindParam(":telefono", $telefono);
            $result->bindParam(":claveMd", $claveMd);
            $result->bindParam(":rol", $rol);
            $result->bindParam(":estado", $estado);
            $result->bindParam(":tipo_formacion", $tipo_formacion);
            $result->bindParam(":foto", $foto);

            // EJECUTAMOS EL INSERT
            $result->execute();

            echo '<script>alert("Usuario Registrado con Exito")</script>';
            echo "<script> location.href='../Views/Extras/page-register.html' </script>";
            }
        }

        public function mostrarUsersAdmin(){

            $f = null;
            // CREAMOS EL OBJETO DE CONEXION 
            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();
            $consultar = "SELECT * FROM users  ";
            $result = $conexion->prepare($consultar);
            $result->execute();           

            while ($resultado = $result->fetch()) {
                $f[] = $resultado;
            }
            return $f;
        }
        public function mostrarUserAdmin($id_user){
            $f = null;

            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();

            $buscar = "SELECT * FROM users WHERE identificacion=:id_user";
            $result = $conexion->prepare($buscar);

            $result->bindParam(':id_user', $id_user);

            $result->execute();

            while ($resultado = $result->fetch()) {
                $f[] = $resultado;
            }
            return $f;
        }

        public function actualizarUserAdmin($identificacion,$tipo_doc,$nombres,$apellidos,$email,$telefono,$rol,$estado,$tipo_formacion){

            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();

            $actualizar = " UPDATE users SET tipo_doc=:tipo_doc, nombres=:nombres, apellidos=:apellidos, email=:email, telefono=:telefono, rol=:rol, estado=:estado tipo_formacion=tipo_formacion WHERE identificacion=:identificacion";
            $result = $conexion->prepare($actualizar);

            $result->bindParam("identificacion", $identificacion);
            $result->bindParam("tipo_doc", $tipo_doc);
            $result->bindParam("nombres", $nombres);
            $result->bindParam("apellidos", $apellidos);
            $result->bindParam("email", $email);
            $result->bindParam("telefono", $telefono);
            $result->bindParam("rol", $rol);
            $result->bindParam("estado", $estado);
            $result->bindParam("tipo_formacion", $tipo_formacion);

            $result->execute();

            echo '<script>alert("Información de usuario actualizada")</script>';
            echo "<script> location.href='../Views/Administrador/ver-usuarios.php' </script>";

        }


        public function modificarCuentaAdmin($identificacion,$tipo_doc,$nombres,$apellidos,$email,$telefono,$tipo_formacion){

            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();

            $actualizar = " UPDATE users SET tipo_doc=:tipo_doc, nombres=:nombres, apellidos=:apellidos, email=:email, telefono=:telefono, tipo_formacion=tipo_formacion WHERE identificacion=:identificacion";
            $result = $conexion->prepare($actualizar);

            $result->bindParam("identificacion", $identificacion);
            $result->bindParam("tipo_doc", $tipo_doc);
            $result->bindParam("nombres", $nombres);
            $result->bindParam("apellidos", $apellidos);
            $result->bindParam("email", $email);
            $result->bindParam("telefono", $telefono);
            $result->bindParam("tipo_formacion", $tipo_formacion);


            $result->execute();

            echo '<script>alert("Información Actualizada")</script>';
            echo "<script> location.href='../Views/Administrador/perfil.php?id=$identificacion' </script>";

        }

        public function eliminarUserAdmin($id){
            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();

            $eliminar = "DELETE FROM users WHERE identificacion=:id";
            $result = $conexion->prepare($eliminar);

            $result->bindParam(":id", $id);

            $result->execute();
            echo '<script>alert("Usuario Eliminado")</script>';
            echo "<script> location.href='../Views/Administrador/ver-usuarios.php' </script>";

        }


        public function verPerfil($id){

            $f = null;

            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();

            $buscar = "SELECT * FROM users WHERE identificacion=:id";
            $result = $conexion->prepare($buscar);

            $result->bindParam(':id', $id);

            $result->execute();

            while ($resultado = $result->fetch()) {
                $f[] = $resultado;
            }
            return $f;
        }

        public function actualizarFotoAdmin($id, $foto){
            
            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();

            $actualizar = "UPDATE users SET foto=:foto WHERE identificacion=:id";
            $result = $conexion->prepare($actualizar);

            $result->bindParam("id", $id);
            $result->bindParam("foto", $foto);

            $result->execute();

            echo '<script>alert("Información Actualizada")</script>';
            echo "<script> location.href='../Views/Administrador/perfil.php?id=$id' </script>";

        }

        public function actualizarClaveAdmin($identificacion, $claveMd){
            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();

            $actualizar = "UPDATE users SET clave=:claveMd WHERE identificacion=:identificacion";
            $result = $conexion->prepare($actualizar);

            $result->bindParam("identificacion", $identificacion);
            $result->bindParam("claveMd", $claveMd);

            $result->execute();

            echo '<script>alert("Información Actualizada")</script>';
            echo "<script> location.href='../Views/Administrador/perfil.php?id=$identificacion' </script>";

        }

        // FUNCIONES MÓDULO PRODUCTOS

    }

    class ValidarSesion{

        public function iniciarSesion($email,$clave){
            
            // CREAMOS EL OBJETO DE CONEXION 
            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();

            $consultar = "SELECT * FROM users WHERE email=:email";

            $result = $conexion->prepare($consultar);

            $result->bindParam(":email", $email);

            $result->execute();

            $f = $result->fetch();
            // VALIDAMOS EL EMAIL
            if ($f) {
                // VALIDAMOS LA CLAVE
                if($f['clave'] == $clave){
                    // VALIDAMOS EL ESTADO DE LA CUENTA
                    if ($f['estado'] == "Activo" ) {
                        // SE REALIZA EL INICIO DE SESION                        
                        session_start();

                        // CREAMOS VARIABLES DE SESIÓN
                        $_SESSION['id'] = $f['identificacion'];
                        $_SESSION['email'] = $f['email'];
                        $_SESSION['rol'] = $f['rol'];
                        $_SESSION['AUTENTICADO'] = "SI";

                        // VALIDAMOS EL ROL PARA REDIRECCIONAR A LA INTERFAZ CORRESPONDIENTE

                        switch ($f['rol']) {
                            case 'Administrador':
                                echo '<script>alert("BIENVENIDO ADMINISTRADOR")</script>';
                                echo "<script> location.href='../Views/Administrador/home.php' </script>";
                                break;
                            case 'Cliente':
                                echo '<script>alert(" BIENVENIDO INSTRUCTOR")</script>';
                                echo "<script> location.href='../Views/Cliente/home.php' </script>";
                                break;
                            case 'Auxiliar':
                                echo '<script>alert(" BIENVENIDO USUARIO")</script>';
                                echo "<script> location.href='../Views/Auxiliar/home.php' </script>";
                                break;
                            
                        }



                    }else{
                        echo '<script>alert("ERROR AL INGRESAR, COMUNICARSE CON EL ADMINISTRADOR")</script>';
                        echo "<script> location.href='../Views/Extras/page-login.html' </script>";    
                    }

                }else{
                    echo '<script>alert("VERIFICA LA INFORMACION INGRESADA")</script>';
                    echo "<script> location.href='../Views/Extras/page-login.html' </script>";
                }

            }else{
                echo '<script>alert("ERROR AL INGRESAR")</script>';
                echo "<script> location.href='../Views/Extras/page-register.html' </script>";
            }


        }


        public function cerrarSesion(){

            $objConexion = new Conexion();
            $conexion = $objConexion->get_conexion();
            
            session_start();
            session_destroy();

            echo "<script>location.href='../Views/Extras/page-login.html'</script>";
        }

    }


?>